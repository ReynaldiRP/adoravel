@extends('template.dashboard')
@section('content')
    <form id="form_update_transaction">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="pet_registration_id">*Nama Hewan Peliharaan Owner</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="pet_registration_id" id="pet_registration_id">
                    <option value="">Pilih Nama Hewan Peliharaan Owner</option>
                    @foreach ($petRegistration as $item)
                        <option value="{{ $item->id }}"
                            {{ $item->id == $transaction->pet_registration_id ? 'selected' : '' }}>
                            {{ $item->pet_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="owner_id">*Nama Pet Owner</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="pet_owner_id" id="pet_owner_id">
                    <option value="">Pilih Nama Owner</option>
                    @foreach ($petOwner as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $transaction->pet_owner_id ? 'selected' : '' }}>
                            {{ $item->first_name . ' ' . $item->last_name }}
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
                        <option value="{{ $item->id }}" {{ $item->id == $transaction->employee_id ? 'selected' : '' }}>
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
                        <option value="{{ $item->id }}" {{ $item->id == $transaction->service_id ? 'selected' : '' }}>
                            {{ $item->serviceType->service_name }}
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
                    value="{{ $transaction->servicePrice->price }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="transaction_method_id">*Pilih Jenis Pembayaran</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="transaction_method_id" id="transaction_method_id">
                    <option value="">Pilih Jenis Pembayaran</option>
                    @foreach ($transaction_method as $item)
                        <option value="{{ $item->id }}"
                            {{ $item->id == $transaction->transaction_method_id ? 'selected' : '' }}>
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
                <input type="date" class="form-control bg-white" name="transaction_date" id="transaction_date"
                    value="{{ $transaction->transaction_date }}">
            </div>
        </div>
        <div class="mt-3 d-flex
                    justify-content-end">
            <a href="{{ route('transaction.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var transactionId = "{{ $transaction->id }}";
        //update data
        $('#form_update_transaction').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('transaction.update', ['transaction' => ':transactionId']) }}"
                    .replace(':transactionId',
                        transactionId),
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Berhasil Update Data',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('transaction.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        Swal.fire(
                            'Failed',
                            'Data gagal diupdate',
                            'error'
                        );
                    }
                    $("#btn-update").text('Update transaction');
                    $("#transactionModal").modal('hide');
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
