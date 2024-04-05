@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-yellow">Add Driver</h2>
</div>

<div class="bg-success2" style="height: 100vh;">
    <div class="container py-2 text-white">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <form method="post" action="{{ route('store_driver') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="driver_name" class="">Driver Name</label>
                    <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="license_number">License Number</label>
                    <input type="text" class="form-control" id="license_number" name="license_number" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="contact_number">Contact Number</label>
                    <input type="number" class="form-control" id="contact_number" name="contact_number" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="driver_status">Driver Status</label>
                    <input type="text" class="form-control" id="driver_status" name="driver_status" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="driver_picture">Driver Picture</label>
                    <input type="file" name="driver_picture" id="driver_picture" accept="image/*">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success">Add Driver</button>
                    <a href="{{ route('driver_inventory') }}" class="my-2 btn btn-warning">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
