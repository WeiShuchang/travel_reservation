@extends('administrator.base')

@section('content')

<style>
    .table-image img {
        max-width: 178px; /* Set the maximum width of the image */
        max-height: 100px; /* Set the maximum height of the image */
    }
</style>


<div class="center bg-success py-3" id="cars">
    <h1 class=" fw-bolder text-yellow mb-2">CAR INVENTORY</h1>
    <!-- Add a circular button aligned with the heading -->
    <a class="btn btn-success btn-circle d-flex justify-content-center align-items-center mx-4 mb-2" href="{{ route('cars_inventory.create') }}">
        <!-- Bootstrap icon -->
        <i class="bi bi-plus-lg"></i> <!-- This will add a plus icon -->
    </a>
</div>

<div class="center bg-success">
    @if(session('success'))
        <div class="alert alert-success" role="alert" id="alert-message">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="center bg-success py-4">
    
    <div class="container row  vh-100 mb-3">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table text-white table-image table-bordered bg-success2">
                    <thead>
                        <tr>
                            <th class="text-yellow" scope="col">Make</th>
                            <th class="text-yellow" scope="col">Picture</th>
                            <th class="text-yellow" scope="col">Plate Number</th>
                            <th class="text-yellow" scope="col">Car Status</th>
                            <th class="text-yellow" scope="col">Seating Capacity</th>
                            <th class="text-yellow" scope="col">Edit</th>
                            <th class="text-yellow" scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @forelse($cars as $car)
                        <tr>
                            <td>{{ $car->make }}</td>
                            <td>
                            @if ($car->car_picture)
                                <img src="{{ asset('storage/cars/' . $car->car_picture) }}" class="img-fluid img-thumbnail" alt="driver">
                            @else
                                <img src="{{ asset('images/default-car.jpg') }}" class="img-fluid img-thumbnail" alt="driver">
                            @endif
                            </td>
                      
                       
                            <td>{{ $car->plate_number }}</td>

                            <td>{{ $car->car_status }}</td>
                            <td>{{ $car->seat_capacity }} passengers</td>
                            <td><a class="btn btn-primary" href="{{ route('cars_inventory.edit', $car->id) }}">Edit</a></td>
                            <td>
                                <form action="{{route('cars_inventory.destroy', $car->id)}}" method="post" id="deleteForm">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">No Cars Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="col-md-12 bg-success py-4">
    {{ $cars->links('vendor.pagination.default') }}
</div>



<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this car?")) {
            document.getElementById("deleteForm").submit();
        }else{
            event.preventDefault();
        }
    }
    // Ensure the DOM is loaded before accessing elements
    document.addEventListener("DOMContentLoaded", function() {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");

        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function() {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000);
    });
</script>

@endsection
