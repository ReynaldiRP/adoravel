@extends('template.dashboard')
@section('content')
    <form id="form_update_employee">
        @method('PUT')
        @csrf
        <div class="row mt-1">
            <div class="col-md-3">
                <label class="font-weight-bold" for="first_name">*Nama Depan</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="first_name" id="first_name"
                    value="{{ $employee->first_name }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="last_name">*Nama Akhir</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="last_name" id="last_name"
                    value="{{ $employee->last_name }}">
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
                        <option value="{{ $item->id }}" {{ $item->id == $employee->gender_id ? 'selected' : '' }}>
                            {{ $item->gender_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="position_id">*Posisi</label>
            </div>
            <div class="col">
                <select class="form-control bg-white" name="position_id" id="position_id">
                    <option value="">Pilih Posisi</option>
                    @foreach ($position as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $employee->position_id ? 'selected' : '' }}>
                            {{ $item->job_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="salary">*Gaji</label>
            </div>
            <div class="col">
                <input type="number" class="form-control bg-white" name="salary" id="salary"
                    value="{{ $employee->salary }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="email">*Email</label>
            </div>
            <div class="col">
                <input type="email" class="form-control bg-white" name="email" id="email"
                    value="{{ $employee->email }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="address">*Alamat</label>
            </div>
            <div class="col">
                <input type="text" class="form-control bg-white" name="address" id="address"
                    value="{{ $employee->address }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="phone_number">*Nomor Telfon</label>
            </div>
            <div class="col">
                <input type="number" class="form-control bg-white" name="phone_number" id="phone_number"
                    value="{{ $employee->phone_number }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="font-weight-bold" for="join_date">*Tanggal Masuk</label>
            </div>
            <div class="col">
                <input type="date" class="form-control bg-white" name="join_date" id="join_date"
                    value="{{ $employee->join_date }}">
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('employee.index') }}" class="btn me-2" style="background-color: white">Back</a>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>
@endsection
@push('script')
    <script>
        var employeeId = "{{ $employee->id }}";
        //update data
        $('#form_update_employee').submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btn-update").text('loading...');
            $.ajax({
                method: "post",
                url: "{{ route('employee.update', ['employee' => ':employeeId']) }}".replace(':employeeId',
                    employeeId),
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
                                window.location.href = "{{ route('employee.index') }}";
                            }
                        });
                    } else if (response.status == 500) {
                        let errorMessage = 'Data gagal di Update';

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
                    $("#btn-update").text('Update employee');
                    $("#employeeModal").modal('hide');
                }
            });
        });
    </script>
@endpush
