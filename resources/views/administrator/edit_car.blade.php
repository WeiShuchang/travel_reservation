@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h1 class="fw-bolder text-yellow mb-2">Edit {{ $car->make }} | {{ $car->plate_number }}</h1>
</div>

  

<div class="bg-success2 container-fluid">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form method="post" action="{{ route('cars_inventory.update', $car->id) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-4 center bg-success2">
                <div class="row text-white">
                    @if ($car->car_picture)
                        <img src="{{ asset('storage/cars/' . $car->car_picture) }}" class="img-fluid img-thumbnail" alt="driver">
                    @else
                        <img src="{{ asset('images/default-car.jpg') }}" class="img-fluid img-thumbnail" alt="driver">
                    @endif
                    <div class="form-group col-md-12 pt-2">
                        <label for="car_picture">Car Image</label>
                        <input type="file" name="car_picture" id="car_picture" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="py-3 col-md-8 text-white">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="make" class="">Make</label>
                        <input type="text" class="form-control" value="{{ $car->make }}" id="make" name="make">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" value="{{ $car->model }}" id="model" name="model">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="year">Year</label>
                        <input type="number" class="form-control" value="{{ $car->year }}" id="year" name="year">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" value="{{ $car->color }}" id="color" name="color" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="plate_number">Plate Number</label>
                        <input type="text" class="form-control" value="{{ $car->plate_number }}" id="plate_number" name="plate_number">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="transmission">Transmission</label>
                        <input type="text" class="form-control" value="{{ $car->transmission }}" id="transmission" name="transmission">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fuel_type">Fuel Type</label>
                        <input type="text" class="form-control" value="{{ $car->fuel_type }}" id="fuel_type" name="fuel_type">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="seat_capacity">Seating Capacity</label>
                        <input type="number" class="form-control"  value="{{ $car->seat_capacity }}" id="seat_capacity" name="seat_capacity" required>
                    </div>

                    <div class="form-group col-md-6 mt-4">
                        <label for="car_status">Car Status</label>
                        <select name="car_status" class="px-3 py-2" id="car_status">
                        @if ($car->car_status == 'available')
                            <option value="available" selected>Available</option>
                            <option value="unavailable" >Unavailable</option>
                        @else
                            <option value="available" >Available</option>
                            <option value="unavailable" selected>Unavailable</option>
                        @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6 ">
                        <button type="submit" class="btn btn-success">Edit Car</button>
                        <a href="{{ route('cars_inventory.index') }}" class="my-2 btn btn-warning">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
