@extends('template.dashboard')
@section('content')
    <form id="form_update_owner">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="first_name">*Nama Depan</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="first_name" id="first_name"
                    value="{{ $petOwner->first_name }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="last_name">*Nama Akhir</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="last_name" id="last_name"
                    value="{{ $petOwner->last_name }}">
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
                        <option value="{{ $item->id }}" {{ $item->id == $petOwner->gender_id ? 'selected' : '' }}>
                            {{ $item->gender_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="email">*Email</label>
            </div>
            <div class="col">
                <input type="email" class="form-control bg-white" name="email" id="email"
                    value="{{ $petOwner->email }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="address">*Alamat</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="address" id="address"
                    value="{{ $petOwner->address }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="phone_number">*Nomor Telfon</label>
            </div>
            <div class="col">
                <input type="number" class="form-control bg-white" name="phone_number" id="phone_number"
                    value="{{ $petOwner->phone_number }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="emergency_phone_number">*Nomor Telfon
                    Darurat</label>
            </div>
            <div class="col">
                <input type="number" class="form-control bg-white" name="emergency_phone_number"
                    id="emergency_phone_number" value="{{ $petOwner->emergency_phone_number }}">
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('petOwner.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var ownerId = "{{ $petOwner->id }}";
        //update data
        $('#form_update_owner').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petOwner.update', ['petOwner' => ':ownerId']) }}".replace(':ownerId',
                    ownerId),
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
                                window.location.href = "{{ route('petOwner.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        Swal.fire(
                            'Failed',
                            'Data gagal diupdate',
                            'error'
                        );
                    }
                    $("#btn-update").text('Update Owner');
                    $("#ownerModal").modal('hide');
                }
            });
        });
    </script>
@endpush
