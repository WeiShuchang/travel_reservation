@extends('administrator.base')

@section('content')

<div class="bg-success vh-100  align-items-center">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h2 class="fw-bolder text-yellow pt-4">Ongoing Travel: </h2>

        <div class="table-responsive">
            <!-- Table for Request Listing -->
            <table class="table table-bordered text-white bg-success2">
                <thead>
                    <tr>
                        <th class="text-yellow">Request ID</th>
                        <th class="text-yellow">Requester Name</th>
                        <th class="text-yellow">Destination</th>
                        <th class="text-yellow">Departure Date</th>
                        <th class="text-yellow">Return Date</th>
                        
                        <th class="text-yellow">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data - Replace with Laravel Blade syntax -->
                    @foreach($reservations as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->requestor_name }}</td>
                        <td>{{ $request->destination }}</td>
                        <td>{{ $request->date_of_travel }}</td>
                        <td>{{ $request->expected_return_date }}</td>
                      
                        <td >
                           
                            <!-- Mark as Complete button -->
                            <form action="{{ route('reservations.complete', $request->id) }}" method="POST" id="completeForm">
                                @csrf
                                @method("PUT")
                                <button type="submit" class="btn btn-sm btn-success mb-1" onclick="confirmComplete()">Complete</button>
                            </form>
                            <form action="{{ route('reservations.cancel', $request->id) }}" method="POST" id="cancelForm">
                                @csrf
                                @method("PUT")
                                <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="confirmCancel()">Cancel</button>
                            </form>

                        
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    


</div>

<script>
    function confirmComplete() {
        if (confirm("Are you sure you want to Complete This Reservation?")) {
            document.getElementById("completeForm").submit();
        }else{
            event.preventDefault(); 
        }
    }

    function confirmCancel() {
        if (confirm("Are you sure you want to Cancel This Reservation?")) {
            document.getElementById("cancelForm").submit();
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
