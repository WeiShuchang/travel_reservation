@extends('administrator.base')

@section('content')

<style>
    .table-image img {
        max-width: 178px; /* Set the maximum width of the image */
        max-height: 100px; /* Set the maximum height of the image */
    }
</style>

<div class="center bg-success py-3" id="cars">
    <h1 class="fw-bolder text-yellow mb-2">DRIVER INVENTORY</h1>
    <!-- Add a circular button aligned with the heading -->
    <a class="btn btn-success btn-circle d-flex justify-content-center align-items-center mx-4 mb-2" href="{{ route('add_driver') }}">
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
</div>

<div class="center bg-success py-2">
    <div class="container row vh-100">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table text-white table-image table-bordered bg-success2">
                    <thead>
                        <tr>
                            <th class="text-yellow" scope="col">Driver Name</th>
                            <th class="text-yellow" scope="col">Picture</th>
                            <th class="text-yellow" scope="col">License Number</th>
                            <th class="text-yellow" scope="col">Contact Number</th>
                            <th class="text-yellow" scope="col">Driver Status</th>
                            <th class="text-yellow" scope="col">Edit</th>
                            <th class="text-yellow" scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @forelse ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->driver_name }}</td>
                            <td>
                                <img src="{{ asset('storage/drivers/' . $driver->driver_picture) }}" class="img-fluid img-thumbnail" alt="driver">
                            </td>
                            <td>{{ $driver->license_number }}</td>
                            <td>{{ $driver->contact_number }}</td>
                            <td>{{ $driver->driver_status }}</td>
                            <td><a class="btn btn-primary" href="{{ route('edit_driver', $driver->id) }}">Edit</a></td>
                            <td>
                                <form action="{{ route('delete_driver', $driver->id) }}" method="post" id="deleteForm">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No Drivers Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this driver?")) {
            document.getElementById("deleteForm").submit();
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
