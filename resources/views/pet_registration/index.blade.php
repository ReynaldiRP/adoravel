@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#petRegistrationModal"
        data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="petRegistration_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>Nama Pet Owner</th>
                    <th>Nama Hewan Peliharaan</th>
                    <th>jenis Hewan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petRegistration as $item)
                    <tr>
                        <td>{{ $item->petOwner->first_name . ' ' . $item->petOwner->last_name }}</td>
                        <td>{{ $item->pet_name }}</td>
                        <td>{{ $item->petType->type }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="petRegistrationId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('petRegistration.edit', ['petRegistration' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="petRegistrationModal" aria-labelledby="petRegistrationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="petRegistrationModalTitle">Tambah Pet Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_petRegistration">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="owner_id">*Nama Pet Owner</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="owner_id" id="owner_id">
                                    <option value="">Pilih Nama Owner</option>
                                    @foreach ($petOwner as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->first_name . ' ' . $item->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="pet_name">*Nama Hewan Peliharaan</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control bg-white" name="pet_name" id="pet_name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="pet_type_id">*Jenis Hewan</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="pet_type_id" id="pet_type_id">
                                    <option value="">Pilih Jenis Hewan</option>
                                    @foreach ($petType as $item)
                                        <option value="{{ $item->id }}">{{ $item->type }}</option>
                                    @endforeach
                                </select>
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
        var petRegistrationId = $('#petRegistrationId').val();

        //data table
        const petRegistrationTable = $('#petRegistration_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_petRegistration").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petRegistration.store') }}",
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
                                fetchpetRegistration(response.data);
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
                    $("#btn-save").text('Tambah Pet Registration');
                    $("#form_petRegistration")[0].reset();
                    $("#petRegistrationModal").modal('hide');
                }
            });
        });

        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const petRegistrationId = form.find('#petRegistrationId').val();
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
                        url: "{{ route('petRegistration.destroy', ['petRegistration' => ':petRegistrationId']) }}"
                            .replace(
                                ':petRegistrationId', petRegistrationId),
                        data: fd, // Use the FormData object
                        processData: false, // Set processData to false for FormData
                        contentType: false, // Set contentType to false for FormData
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Data Berhasil di Hapus.',
                                icon: 'success'
                            }).then(function() {
                                const row = form.closest('tr');
                                petRegistrationTable.row(row).remove().draw();
                            });
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

        function fetchpetRegistration(data) {
            const ownerName = data.owner_name.first_name + ' ' + data.owner_name.last_name;
            const petType = data.pet_type.type;
            const petRegistrationRow = [
                ownerName,
                data.pet_name,
                petType,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="petRegistrationId" value="${data.id}">
                    <a class="btn btn-success" href="/petRegistration/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];

            petRegistrationTable.row.add(petRegistrationRow).draw();
        }
    </script>
@endpush
