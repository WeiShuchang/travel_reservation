@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h1 class="fw-bolder text-yellow mb-2">Edit {{ $driver->driver_name }} | {{ $driver->contact_number }}</h1>
</div>



<div class="container-fluid bg-success2" style="height:100vh;">
        @if($errors->any())
        
                <div class="alert alert-danger  ">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        
        @endif
    <form method="post" action="{{ route('update_driver', $driver->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4 center bg-success2">
            <div class="row text-white">
                <img class="img-fluid img-thumbnail col-md-12" src="{{ asset('storage/drivers/' . $driver->driver_picture) }}" alt="" width="400px" height="200">
            </div>
        </div>

        <div class="py-3 col-md-8 text-white">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="driver_name">Driver Name</label>
                    <input type="text" class="form-control" value="{{ $driver->driver_name }}" id="driver_name" name="driver_name">
                </div>

                <div class="form-group col-md-6">
                    <label for="license_number">License Number</label>
                    <input type="text" class="form-control" value="{{ $driver->license_number }}" id="license_number" name="license_number">
                </div>
        
                <div class="form-group col-md-6">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="form-control" value="{{ $driver->contact_number }}" id="contact_number" name="contact_number">
                </div>
                
                <div class="form-group col-md-6">
                    <label for="driver_status">Driver Status</label>
                    <input type="text" class="form-control" value="{{ $driver->driver_status }}" id="driver_status" name="driver_status">
                </div>
                
                <div class="form-group col-md-6 pt-2">
                    <label for="driver_picture">Driver Image</label>
                    <input type="file" name="driver_picture" id="driver_picture" accept="image/*">
                </div>

                <div class="form-group col-md-6 mt-4">
                    <button type="submit" class="btn btn-success">Edit Driver</button>
                    <a href="{{ route('driver_inventory') }}" class="my-2 btn btn-warning">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection
