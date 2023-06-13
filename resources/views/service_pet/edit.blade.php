@extends('template.dashboard')
@section('content')
    <form id="form_update_servicePet">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="service_id">*Jenis Layanan Hewan</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="service_id" id="service_id">
                    <option value="">Pilih Jenis Layanan</option>
                    @foreach ($serviceType as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $servicePet->service_id ? 'selected' : '' }}>
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
                <input type="number" class="form-control bg-white" name="price" id="price"
                    value="{{ $servicePet->price }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="description">*Description</label>
            </div>
            <div class="col">
                <textarea class="form-control" name="description" id="description" cols="30" rows="3" disabled>{{ $servicePet->serviceType->description }}</textarea>
            </div>
        </div>
        <div class="mt-3 d-flex
                    justify-content-end">
            <a href="{{ route('servicePet.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var servicePetId = "{{ $servicePet->id }}";
        //update data
        $('#form_update_servicePet').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('servicePet.update', ['servicePet' => ':servicePetId']) }}"
                    .replace(':servicePetId',
                        servicePetId),
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
                                window.location.href = "{{ route('servicePet.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        Swal.fire(
                            'Failed',
                            'Data gagal diupdate',
                            'error'
                        );
                    }
                    $("#btn-update").text('Update servicePet');
                    $("#servicePetModal").modal('hide');
                }
            });
        });

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
