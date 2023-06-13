@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#petFoodModal" data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="petFood_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>Nama Makanan Hewan</th>
                    <th>Harga</th>
                    <th>Brand</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petFood as $item)
                    <tr>
                        <td>{{ $item->petFoodType->food_name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->petFoodType->brand }}</td>
                        <td>{{ $item->petFoodType->description }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="petFoodId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('petFood.edit', ['petFood' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="petFoodModal" aria-labelledby="petFoodModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="petFoodModalTitle">Tambah Makanan Hewan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_petFood">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="pet_food_id">*Jenis Makanan Hewan</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="pet_food_id" id="pet_food_id">
                                    <option value="">Pilih Jenis Makanan</option>
                                    @foreach ($petFoodType as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->food_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="price">*Harga Makanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="price" id="price">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="brand">*Brand</label>
                            </div>
                            <div class="col">
                                <input type="text" name="brand" id="brand" value="" disabled>
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
        var petFoodId = $('#petFoodId').val();

        //data table
        const petFoodTable = $('#petFood_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_petFood").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petFood.store') }}",
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
                                fetchpetFood(response.data);
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
                    $("#btn-save").text('Tambah Makanan Hewan');
                    $("#form_petFood")[0].reset();
                    $("#petFoodModal").modal('hide');
                }
            });
        });

        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const petFoodId = form.find('#petFoodId').val();
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
                        url: "{{ route('petFood.destroy', ['petFood' => ':petFoodId']) }}"
                            .replace(
                                ':petFoodId', petFoodId),
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
                                petFoodTable.row(row).remove().draw();
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

        function fetchpetFood(data) {
            const foodName = data.food_type.food_name;
            const foodBrand = data.food_type.brand;
            const foodDesc = data.food_type.description;
            const petFoodRow = [
                foodName,
                data.price,
                foodBrand,
                foodDesc,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="petFoodId" value="${data.id}">
                    <a class="btn btn-success" href="/petFood/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];

            petFoodTable.row.add(petFoodRow).draw();
        }

        $(document).ready(function() {
            $('#pet_food_id').change(function() {
                const petFoodId = $(this).val();

                if (petFoodId === '') {
                    $('#brand').val('');
                    $('#description').val('');
                } else {
                    $.ajax({
                        method: 'GET',
                        url: '/get_detail_food/' + petFoodId,
                        success: function(response) {
                            console.log(response);
                            $('#brand').val(response.data.brand);
                            $('#description').val(response.data.description);
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
