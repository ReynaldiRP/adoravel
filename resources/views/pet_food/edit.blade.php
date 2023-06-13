@extends('template.dashboard')
@section('content')
    <form id="form_update_petFood">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="pet_food_id">*Jenis Makanan Hewan</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="pet_food_id" id="pet_food_id">
                    <option value="">Pilih Jenis Makanan</option>
                    @foreach ($petFoodType as $item)
                        <option value="{{ $item->id }}" {{ $item->id === $petFood->pet_food_id ? 'active' : '' }}>
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
                <input type="number" class="form-control bg-white" name="price" id="price"
                    value="{{ $petFood->price }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="brand">*Brand</label>
            </div>
            <div class="col">
                <input type="text" name="brand" id="brand" value="{{ $petFood->petFoodType->brand }}" disabled>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="description">*Description</label>
            </div>
            <div class="col">
                <textarea class="form-control" name="description" id="description" cols="30" rows="3" disabled>{{ $petFood->petFoodType->description }}</textarea>
            </div>
        </div>
        <div class="mt-3 d-flex
                    justify-content-end">
            <a href="{{ route('petFood.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var petFoodId = "{{ $petFood->id }}";
        //update data
        $('#form_update_petFood').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('petFood.update', ['petFood' => ':petFoodId']) }}"
                    .replace(':petFoodId',
                        petFoodId),
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
                                window.location.href = "{{ route('petFood.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        Swal.fire(
                            'Failed',
                            'Data gagal diupdate',
                            'error'
                        );
                    }
                    $("#btn-update").text('Update petFood');
                    $("#petFoodModal").modal('hide');
                }
            });
        });

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
