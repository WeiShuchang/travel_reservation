@extends('user.base')

@section('content')


<div class="center bg-success2 pt-3" id="cars">
    <h1 class="fw-bolder text-warning">Vehicles</h1>
</div>



<div class="container-fluid bg-success2 pt-3">

<div class="bg-success2 pt-3" id="cars">
    <h2 class="fw-bolder text-warning">Available Vehicles:</h2>
</div>
  <div class="row" id="carList">
  @foreach ($available_cars as $car)
    <div class="col-md-3 my-3">
      <div class="card bg-success text-white">
        <img src="{{ asset('storage/cars/' . $car->car_picture) }}" class="card-img-top" alt="Car Picture" height="200">
        <div class="card-body">
          <h5 class="card-title">{{$car->make}} | {{$car->model}}</h5>
          <p class="card-text">Seating Capacity: {{$car->seat_capacity}}</p>
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>

<div class="container-fluid bg-success2 pt-3">
<div class="bg-success2 pt-3" id="cars">
    <h2 class="fw-bolder text-warning">Unavailable Vehicles:</h2>
</div>
  <div class="row" id="carList">

  @foreach ($unavailable_cars as $car)
    <div class="col-md-3 my-3">
      <div class="card bg-success text-white">
        <img src="{{ asset('storage/cars/' . $car->car_picture) }}" class="card-img-top" alt="DriverPicture" height="200">
        <div class="card-body">
          <h5 class="card-title">{{$car->make}} | {{$car->model}}</h5>
        
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>


<div class="center bg-success2 pt-5" id="cars">
    <h1 class="fw-bolder text-warning">Drivers</h1>
</div>


<div class="container-fluid bg-success2 pt-3">
<div class="bg-success2 pt-3" id="cars">
    <h2 class="fw-bolder text-warning">Available Drivers:</h2>
</div>
  <div class="row" id="carList">

  @foreach ($available_drivers as $driver)
    <div class="col-md-3 my-3">
      <div class="card bg-success text-white">
        <img src="{{ asset('storage/drivers/' . $driver->driver_picture) }}" class="card-img-top" alt="Car Picture" height="200">
        <div class="card-body">
          <h5 class="card-title">{{$driver->driver_name}} </h5>
        
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>




<div class="container-fluid bg-success2 pt-3">
<div class="bg-success2 pt-3" id="cars">
    <h2 class="fw-bolder text-warning">Unavailable Drivers:</h2>
</div>
  <div class="row" id="carList">

  @foreach ($unavailable_drivers as $driver)
    <div class="col-md-3 my-3">
      <div class="card bg-success text-white">
        <img src="{{ asset('storage/drivers/' . $driver->driver_picture) }}" class="card-img-top" alt="DriverPicture" height="200">
        <div class="card-body">
          <h5 class="card-title">{{$driver->driver_name}} </h5>
          
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
