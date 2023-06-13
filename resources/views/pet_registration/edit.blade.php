@extends('template.dashboard')
@section('content')
    <form id="form_update_petRegistration">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="owner_id">*Nama Pet Owner</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="owner_id" id="owner_id">
                    <option value="">Pilih Nama Owner</option>
                    @foreach ($petOwner as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $petRegistration->owner_id ? 'selected' : '' }}>
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
                <input type="text" class="form-control bg-white" name="pet_name" id="pet_name"
                    value="{{ $petRegistration->pet_name }}">
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
                        <option value="{{ $item->id }}"
                            {{ $item->id == $petRegistration->pet_type_id ? 'selected' : '' }}>{{ $item->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('petRegistration.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var petRegistrationId = "{{ $petRegistration->id }}";
        //update data
        $('#form_update_petRegistration').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petRegistration.update', ['petRegistration' => ':petRegistrationId']) }}"
                    .replace(':petRegistrationId',
                        petRegistrationId),
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
                                window.location.href = "{{ route('petRegistration.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        Swal.fire(
                            'Failed',
                            'Data gagal diupdate',
                            'error'
                        );
                    }
                    $("#btn-update").text('Update petRegistration');
                    $("#petRegistrationModal").modal('hide');
                }
            });
        });
    </script>
@endpush
