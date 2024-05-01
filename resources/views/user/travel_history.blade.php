@extends('user.base')

@section('content')

<div class="bg-success vh-100  align-items-center">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h2 class="fw-bolder text-primary pt-4">Successful Travel:</h2>

        <div class="table-responsive">
            <!-- Table for Request Listing -->
            <table class="table table-bordered text-white bg-success2">
                <thead>
                    <tr>
                  
                        <th class="text-yellow">Requester Name</th>
                        <th class="text-yellow">Destination</th>
                        <th class="text-yellow">Departure Date</th>
                        <th class="text-yellow">Return Date</th>
                        
                        <th class="text-yellow">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data - Replace with Laravel Blade syntax -->
                    @forelse($reservations as $request)
                    <tr>
                 
                        <td>{{ $request->requestor_name }}</td>
                        <td>{{ $request->destination }}</td>
                        <td>{{ $request->date_of_travel }}</td>
                        <td>{{ $request->expected_return_date }}</td>
                        <td>
                        <a href="{{route('reservation.show_details', $request->id)}}" class="btn btn-sm btn-primary mb-2" >Show Details</a>
                            
                        </td>
                      
                    </tr>
                    @empty
                    <tr>
                        <td>No Reservations</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    


</div>

<div class="col-md-12 bg-success py-4">
    {{ $reservations->links('vendor.pagination.default') }}
</div>


<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to Delete This Reservation?")) {
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
