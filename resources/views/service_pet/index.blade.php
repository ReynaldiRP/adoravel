@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#servicePetModal"
        data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="servicePet_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>Jenis Layanan</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicePet as $item)
                    <tr>
                        <td>{{ $item->serviceType->service_name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->serviceType->description }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="servicePetId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('servicePet.edit', ['servicePet' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="servicePetModal" aria-labelledby="servicePetModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="servicePetModalTitle">Tambah Layanan Hewan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_servicePet">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="service_id">*Jenis Layanan Hewan</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="service_id" id="service_id">
                                    <option value="">Pilih Jenis Layanan</option>
                                    @foreach ($serviceType as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="price">*Harga Layanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="price" id="price">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="description">*Description</label>
                            </div>
                            <div class="col">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="3" disabled>
                                </textarea>
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
        var servicePetId = $('#servicePetId').val();

        //data table
        const servicePetTable = $('#servicePet_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_servicePet").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('servicePet.store') }}",
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
                                fetchservicePet(response.data);
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
                    $("#form_servicePet")[0].reset();
                    $("#servicePetModal").modal('hide');
                }
            });
        });

        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const servicePetId = form.find('#servicePetId').val();
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
                        url: "{{ route('servicePet.destroy', ['servicePet' => ':servicePetId']) }}"
                            .replace(
                                ':servicePetId', servicePetId),
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
                                servicePetTable.row(row).remove().draw();
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

        function fetchservicePet(data) {
            const serviceName = data.service_type.service_name;
            const serviceDesc = data.service_type.description;
            const servicePetRow = [
                serviceName,
                data.price,
                serviceDesc,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="servicePetId" value="${data.id}">
                    <a class="btn btn-success" href="/servicePet/edit/${data.id}">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];

            servicePetTable.row.add(servicePetRow).draw();
        }

        $(document).ready(function() {
            $('#service_id').change(function() {
                const servicePetId = $(this).val();

                if (servicePetId === '') {
                    $('#description').val('');
                } else {
                    $.ajax({
                        method: 'GET',
                        url: '/get_detail_service/' + servicePetId,
                        success: function(response) {
                            console.log(response);
                            $('#description').val(response.data);
                        },
                        error: function(xhr, status, error) {
                            console.log('Failed to fetch description:', error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
