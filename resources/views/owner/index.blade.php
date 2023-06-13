@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#ownerModal" data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="owner_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Emergency Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petOwner as $item)
                    <tr>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ $item->last_name }}</td>
                        <td>{{ $item->gender->gender_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone_number }}</td>
                        <td>{{ $item->emergency_phone_number }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="petOwnerId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('petOwner.edit', ['petOwner' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="ownerModal" aria-labelledby="ownerModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="ownerModalTitle">Tambah Pet Owner</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_owner">
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
                                <label class="font-weight-bold" for="durasi">*Jenis Kelamin</label>
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
                                <input type="number" class="form-control bg-white" name="phone_number" id="phone_number">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="emergency_phone_number">*Nomor Telfon
                                    Darurat</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="emergency_phone_number"
                                    id="emergency_phone_number">
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
        var ownerId = $('#petOwnerId').val();

        //data table
        const petOwnerTable = $('#owner_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_owner").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petOwner.store') }}",
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
                                fetchPetOwner(response.data);
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
                    $("#btn-save").text('Tambah Owner');
                    $("#form_owner")[0].reset();
                    $("#ownerModal").modal('hide');
                }
            });
        });

        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const petOwnerId = form.find('#petOwnerId').val();
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
                        url: "{{ route('petOwner.destroy', ['petOwner' => ':petOwnerId']) }}"
                            .replace(':petOwnerId', petOwnerId),
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
                                    petOwnerTable.row(row).remove().draw();
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

        function fetchPetOwner(data) {
            const genderName = data.gender.gender_name;
            const petOwnerRow = [
                data.first_name,
                data.last_name,
                genderName,
                data.email,
                data.address,
                data.phone_number,
                data.emergency_phone_number,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="petOwnerId" value="${data.id}">
                    <a class="btn btn-success" href="/petOwner/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];

            petOwnerTable.row.add(petOwnerRow).draw();
        }
    </script>
@endpush
