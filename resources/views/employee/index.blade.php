@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#employeeModal" data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="employee_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Tanggal Masuk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employee as $item)
                    <tr>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ $item->last_name }}</td>
                        <td>{{ $item->gender->gender_name }}</td>
                        <td>{{ $item->position->job_name }}</td>
                        <td>{{ $item->salary }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone_number }}</td>
                        <td>{{ $item->join_date }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="employeeId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('employee.edit', ['employee' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="employeeModal" aria-labelledby="employeeModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="employeeModalTitle">Tambah employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_employee">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="first_name">*Nama Depan</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control bg-white" name="first_name" id="first_name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="last_name">*Nama Akhir</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control bg-white" name="last_name" id="last_name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="gender_id">*Jenis Kelamin</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="gender_id" id="gender_id">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    @foreach ($gender as $item)
                                        <option value="{{ $item->id }}">{{ $item->gender_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="position_id">*Posisi</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="position_id" id="position_id">
                                    <option value="">Pilih Posisi</option>
                                    @foreach ($position as $item)
                                        <option value="{{ $item->id }}">{{ $item->job_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="salary">*Gaji</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="salary" id="salary">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="email">*Email</label>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control bg-white" name="email" id="email">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="address">*Alamat</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control bg-white" name="address" id="address">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="phone_number">*Nomor Telfon</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="phone_number"
                                    id="phone_number">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="join_date">*Tanggal Masuk</label>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control bg-white" name="join_date" id="join_date">
                            </div>
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" id="btn-close" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="btn-save">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var employeeId = $('#employeeId').val();

        //data table
        const employeeTable = $('#employee_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_employee").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('employee.store') }}",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Berhasil Tambah Data',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                fetchEmployee(response.data);
                            }
                        });
                    } else if (response.status == 500) {
                        let errorMessage = 'Data gagal ditambahkan';

                        if (response.errors && response.errors.length > 0) {
                            errorMessage += '<br><br>';
                            response.errors.forEach(function(error) {
                                errorMessage += error + '<br>';
                            });
                        }

                        Swal.fire(
                            'Failed',
                            errorMessage,
                            'error'
                        );
                    }

                    $("#btn-save").text('Tambah Pegawai');
                    $("#form_employee")[0].reset();
                    $("#employeeModal").modal('hide');
                }
            });
        });


        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const employeeId = form.find('#employeeId').val();
            $("#btn_delete").text('loading...');
            swalWithBootstrapButtons.fire({
                title: 'Apakah Anda Yakin Hapus Data',
                text: 'Berhasil Hapus Data',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya Hapus Data',
                cancelButtonText: 'Tidak Hapus Data',
                reverseButtons: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        url: "{{ route('employee.destroy', ['employee' => ':employeeId']) }}"
                            .replace(
                                ':employeeId', employeeId),
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Data Berhasil di Hapus.',
                                    icon: 'success'
                                }).then(function() {
                                    const row = form.closest('tr');
                                    employeeTable.row(row).remove().draw();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed',
                                    text: response.message,
                                    icon: 'error'
                                });
                                $("#btn_delete").text('Delete');
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Data Tidak Jadi di Hapus :)',
                        'error'
                    );
                    $("#btn_delete").text('Delete');
                }
            });
        });


        function fetchEmployee(data) {
            const genderName = data.gender.gender_name;
            const jobName = data.position.job_name;
            const employeeRow = [
                data.first_name,
                data.last_name,
                genderName,
                jobName,
                data.salary,
                data.email,
                data.address,
                data.phone_number,
                data.join_date,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="employeeId" value="${data.id}">
                    <a class="btn btn-success" href="/employee/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];

            employeeTable.row.add(employeeRow).draw();
        }
    </script>
@endpush
