@extends('template.dashboard')
@section('content')
    {{-- @php
        dd($petRegistration);
    @endphp --}}
    <button class="btn btn-primary mb-3" id="btn_tambah" data-bs-target="#transactionModal"
        data-bs-toggle="modal">Tambah</button>

    <div class="table-responsive no-scrollbar">
        <table id="transaction_table" class="table table-striped mt-3" style="width: 100%">
            <thead>
                <tr>
                    <th>Nama Hewan Peliharaan Owner</th>
                    <th>Nama Owner</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Layanan</th>
                    <th>Harga Layanan</th>
                    <th>Tipe Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction as $item)
                    <tr>
                        <td>{{ $item->petRegistration->pet_name }}</td>
                        <td>{{ $item->petOwner->first_name . ' ' . $item->petOwner->last_name }}</td>
                        <td>{{ $item->employee->first_name . ' ' . $item->petOwner->last_name }}</td>
                        <td>{{ $item->servicePrice->serviceType->service_name }}</td>
                        <td>{{ $item->servicePrice->price }}</td>
                        <td>{{ $item->transactionMethod->transaction_type }}</td>
                        <td>{{ $item->transaction_date }}</td>
                        <td>
                            <form id="form_delete">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group" role="group">
                                    <input hidden id="transactionId" value="{{ $item->id }}">
                                    <a class="btn btn-success"
                                        href="{{ route('transaction.edit', ['transaction' => $item->id]) }}">Update</a>
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                                    <button class="btn btn-warning btn_print"
                                        data-transaction-id="{{ $item->id }}">Print</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="transactionModal" aria-labelledby="transactionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="transactionModalTitle">Tambah Pet Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_transaction">
                    <div class="modal-body m-2">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="owner_id">*Nama Pet Owner</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="pet_owner_id" id="pet_owner_id">
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
                                <label class="font-weight-bold" for="pet_registration_id">*Nama Hewan Peliharaan
                                    Owner</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="pet_registration_id" id="pet_registration_id">
                                    <option value="">Pilih Nama Hewan Peliharaan</option>
                                    @foreach ($petRegistration as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->pet_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="employee_id">*Nama Pegawai</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="employee_id" id="employee_id">
                                    <option value="">Pilih Nama Pegawai</option>
                                    @foreach ($employee as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->first_name . ' ' . $item->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="service_id">*Service Type</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="service_id" id="service_id">
                                    <option value="">Pilih Jenis Layanan</option>
                                    @foreach ($servicePet as $item)
                                        <option value="{{ $item->id }}">{{ $item->serviceType->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="price">*Total Harga Layanan</label>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control bg-slate-500" name="price" id="price"
                                    disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="transaction_method_id">*Pilih Jenis Pembayaran</label>
                            </div>
                            <div class="col">
                                <select class="form-control bg-white" name="transaction_method_id"
                                    id="transaction_method_id">
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    @foreach ($transaction_method as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->transaction_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="transaction_date">*Tanggal Transaksi</label>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control bg-white" name="transaction_date"
                                    id="transaction_date">
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
        var transactionId = $('#transactionId').val();

        //data table
        const transactionTable = $('#transaction_table').DataTable({
            responsive: true
        });

        $(document).on('click', '.btn_print', function(e) {
            e.preventDefault();
            var transactionId = $(this).data('transaction-id');
            var printUrl = "/print_transaction/" + transactionId;
            var printWindow = window.open(printUrl, '_blank');
            printWindow.document.addEventListener('DOMContentLoaded', function() {
                printWindow.print();
            });
        });

        //insert data
        $("#form_transaction").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-save").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('transaction.store') }}",
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
                                fetchtransaction(response.data);
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
                    $("#form_transaction")[0].reset();
                    $("#transactionModal").modal('hide');
                }
            });
        });

        $(document).on('submit', '#form_delete', function(e) {
            e.preventDefault();
            const form = $(this);
            const fd = new FormData(this);
            const transactionId = form.find('#transactionId').val();
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
                        url: "{{ route('transaction.destroy', ['transaction' => ':transactionId']) }}"
                            .replace(
                                ':transactionId', transactionId),
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
                                transactionTable.row(row).remove().draw();
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

        function fetchtransaction(data) {
            const petName = data.pet.pet_name;
            const ownerName = data.owner_name.first_name + ' ' + data.owner_name.last_name;
            const employeeName = data.employee_name.first_name + ' ' + data.employee_name.last_name;
            const servicePrice = data.service_type.price;
            const serviceType = data.service_type.service_name;
            const transaction_method = data.transaction_method.type
            const transactionRow = [
                petName,
                ownerName,
                employeeName,
                serviceType,
                servicePrice,
                transaction_method,
                data.transaction_date,
                `
            <form id="form_delete">
                @csrf
                @method('DELETE')
                <div class="btn-group" role="group">
                    <input hidden id="transactionId" value="${data.id}">
                    <a class="btn btn-success" href="/transaction/${data.id}/edit">Update</a>
                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>
                    <button class="btn btn-warning btn_print" data-transaction-id="${data.id}">Print</button>
                </div>
            </form>
            `
            ];

            transactionTable.row.add(transactionRow).draw();
        }
        $(document).ready(function() {
            $('#service_id').change(function() {
                const servicePetId = $(this).val();
                if (servicePetId === '') {
                    $('#price').val('');
                } else {
                    $.ajax({
                        method: 'GET',
                        url: '/get_detail_service_price/' + servicePetId,
                        success: function(response) {
                            $('#price').val(response.data || '0');
                        },
                        error: function(error) {
                            console.log('Failed to fetch description:', error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
