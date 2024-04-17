@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-yellow">Add Car </h2>
</div>

<div class="bg-success2">
    <div class="container py-2 text-white">

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="post" action="{{ route('cars_inventory.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="make" class="">Make</label>
                    <input type="text" class="form-control" id="make" name="make" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="year">Year</label>
                    <input type="number" class="form-control" id="year" name="year" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="plate_number">Plate Number</label>
                    <input type="text" class="form-control" id="plate_number" name="plate_number" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="mileage">Mileage</label>
                    <input type="number" class="form-control" id="mileage" name="mileage" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="engine_size">Engine Size</label>
                    <input type="number" class="form-control" id="engine_size" name="engine_size" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="transmission">Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="fuel_type">Fuel Type</label>
                    <input type="text" class="form-control" id="fuel_type" name="fuel_type" required>
                </div>

                <div class="form-group col-md-6 mt-4">
                    <label for="car_status">Car Status</label>
                    <select name="car_status" class="px-3 py-2" id="car_status">
                        <option value="available" selected>Available</option>
                        <option value="unavailable" >Unavailable</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="car_picture">Car Image</label>
                    <input type="file" name="car_picture" id="car_picture" accept="image/*" required>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success col-md-3">Add Car</button>
                    <a href="{{ route('cars_inventory.index') }}" class="my-2 btn btn-warning col-md-3">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
