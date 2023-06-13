@extends('template.dashboard')
@section('content')
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#detail_transactionModal"
        data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="detail_transaction_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>Transaction Id</th>
                    <th>Pet Name</th>
                    <th>Jenis Layanan</th>
                    <th>Harga Layanan</th>
                    <th>Jenis Makanan</th>
                    <th>Harga Makanan</th>
                    <th>Quantity Makanan</th>
                    <th>Total Bayar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail_transaction as $item)
                    @php
                        $id = formatTransactionId($item->transaction->id);
                    @endphp
                    <tr>
                        <td>{{ $id }}</td>
                        <td>{{ $item->petRegistration->pet_name }}</td>
                        <td>{{ $item->servicePet->serviceType->service_name }}</td>
                        <td>{{ $item->servicePet->price }}</td>
                        <td>{{ $item->PetFood->petFoodType->food_name }}</td>
                        <td>{{ $item->petFood->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->total_amount }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="detail_transactionId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('detail_transaction.edit', ['detail_transaction' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="detail_transactionModal" aria-labelledby="detail_transactionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="detail_transactionModalTitle">Tambah Pet Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_detail_transaction">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="transaction_id">*Transaction Id</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="transaction_id" id="transaction_id">
                                    <option value="">Pilih Transaksi</option>
                                    @foreach ($transaction as $item)
                                        <option value="{{ $item->id }}">
                                            {{ formatTransactionId($item->id) }}
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
                                <select class="form-control  bg-slate-500" name="pet_registration_id"
                                    id="pet_registration_id">
                                    <option value="">Nama Hewan Peliharaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="service_name">*Jenis Layanan</label>
                            </div>
                            <div class="col">
                                <select class="form-control  bg-slate-500" name="service_id" id="service_id">
                                    <option value="">Jenis Layanan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="service_price">*Harga Layanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-slate-500" name="service_price"
                                    id="service_price" disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="food_name">*Jenis Makanan</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="pet_food_id" id="food_name">
                                    <option value="">Pilih Jenis Makanan</option>
                                    @foreach ($petFood as $item)
                                        <option value="{{ $item->id }}">{{ $item->petFoodType->food_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="food_price">*Harga Makanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-slate-500" name="food_price" id="food_price"
                                    disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="quantity">*Jumlah Makanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-white" name="quantity" id="quantity">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="total_amount">*Total Harga</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control bg-white" name="total_amount"
                                    id="total_amount">
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
        var detail_transactionId = $('#detail_transactionId').val();
        var totalPrice = 0;
        //data table
        const detail_transactionTable = $('#detail_transaction_table').DataTable({
            responsive: true
        });

        //insert data
        $("#form_detail_transaction").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('detail_transaction.store') }}",
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
                                fetchdetail_transaction(response.data);
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
                    $("#form_detail_transaction")[0].reset();
                    $('#pet_registration_id').empty();
                    $('#service_id').empty();
                    $("#detail_transactionModal").modal('hide');
                }
            });
        });

        //delete data
        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const detail_transactionId = form.find('#detail_transactionId').val();
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
                        url: "{{ route('detail_transaction.destroy', ['detail_transaction' => ':detail_transactionId']) }}"
                            .replace(
                                ':detail_transactionId', detail_transactionId),
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
                                detail_transactionTable.row(row).remove().draw();
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


        //fetch data from detail_transaction table from json response
        function fetchdetail_transaction(data) {
            const transaction_id = data.transaction.transaction_id;
            const pet_name = data.pet_registration.pet_name;
            const service_name = data.service_type.service_name;
            const service_price = data.service_type.service_price;
            const pet_food = data.pet_food.pet_food_name;
            const pet_food_price = data.pet_food.pet_food_price;

            const detail_transactionRow = [
                transaction_id,
                pet_name,
                service_name,
                service_price,
                pet_food,
                pet_food_price,
                data.quantity,
                data.total_amount,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="detail_transactionId" value="${data.id}">
                    <a class="btn btn-success" href="/detail_transaction/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                </div>
            </form>
            `
            ];
            console.log(detail_transactionRow);
            detail_transactionTable.row.add(detail_transactionRow).draw();
        }

        //get detail transaction based on id transaction
        $(document).ready(function() {
            $('#transaction_id').change(function() {
                const transactionId = $(this).val();
                if (transactionId === '') {
                    $('#pet_registration_id').empty(); // Clear existing options
                    $('#pet_registration_id').append('<option value="">Nama Hewan Peliharaan</option>');
                    $('#service_id').empty();
                    $('#service_id').append('<option value="">Jenis Layanan</option>');
                    $('#service_name').val('');
                    $('#service_price').val('');
                } else {
                    $.ajax({
                        method: 'GET',
                        url: '/get_detail_transaction/' + transactionId,
                        success: function(response) {
                            $('#pet_registration_id').empty();
                            $('#pet_registration_id').append(
                                `<option value="${response.data.pet_registration_id}">${response.data.pet_name}</option>`
                            );
                            $('#service_id').empty();
                            $('#service_id').append(
                                `<option value="${response.data.service_id}">${response.data.service_name}</option>`
                            );
                            $('#service_price').val(response.data
                                .service_price || '0');
                            $('#pet_registration_id').val(response.data.pet_registration_id);
                            $('#service_id').val(response.data.service_id);
                        },
                        error: function(error) {
                            console.log('Failed to fetch description:', error);
                        }
                    });
                }
            });
        });


        //get price based on id pet_food
        $(document).ready(function() {
            $('#food_name').change(function() {
                const foodPetId = $(this).val();

                if (foodPetId === '') {
                    $('#food_price').val('');
                } else {
                    $.ajax({
                        method: 'GET',
                        url: '/get_food_price/' + foodPetId,
                        success: function(response) {
                            $('#food_price').val(response.data ||
                                '0');
                        },
                        error: function(xhr, status, error) {
                            console.log('Failed to fetch description:', error);
                        }
                    });
                }
            });
        });

        //sum total price based on service price and food_price time quantity
        $('#quantity').on('keyup', function() {
            const quantity = parseInt($(this).val());
            const servicePrice = parseInt($('#service_price').val());
            const foodPrice = parseInt($('#food_price').val());

            if (!isNaN(quantity) && !isNaN(servicePrice) && !isNaN(foodPrice)) {
                var totalPrice = (servicePrice + foodPrice) * quantity;
                console.log(totalPrice);
                $('#total_amount').val(formatPriceIDR(totalPrice));
            } else {
                $('#total_amount').val('');
            }
        });



        function formatPriceIDR(price) {
            return 'Rp.' + price.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
        }
    </script>
@endpush
