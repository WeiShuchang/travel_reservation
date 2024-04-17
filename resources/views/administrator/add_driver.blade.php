@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-yellow">Add Driver</h2>
</div>

<div class="bg-success2" style="height: 100vh;">
    <div class="container py-2 text-white">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" action="{{ route('drivers_inventory.store') }}" enctype="multipart/form-data">
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
                <div class="form-group col-md-6 mt-4">
                    <label for="driver_status">Driver Status</label>
                    <select name="driver_status" class="px-3 py-2" id="driver_status">
                        <option value="available" >Available</option>
                        <option value="unavailable" >Unavailable</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="driver_picture">Driver Picture</label>
                    <input type="file" name="driver_picture" id="driver_picture" accept="image/*" required>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success">Add Driver</button>
                    <a href="{{ route('drivers_inventory.index') }}" class="my-2 btn btn-warning">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
