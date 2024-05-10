@extends('administrator.base')

@section('content')

<div class="bg-success vh-100  align-items-center">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h2 class="fw-bolder text-danger pt-4">Cancelled Travel: </h2>

        <div class="table-responsive">
            <!-- Table for Request Listing -->
            <table class="table table-bordered text-white bg-success2">
                <thead>
                    <tr>
                        <th class="text-yellow">Requester Name</th>
                        <th class="text-yellow">Cancelled At:</th>
                        <th class="text-yellow">Reason of Cancellation:</th>
                        <th class="text-yellow">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data - Replace with Laravel Blade syntax -->
                    @foreach($reservations as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->updated_at->format('M d, Y') }}</td>
                        <td>{{ $request->reason_for_cancel }}</td>
                        <td>
                            <form action="{{ route('reservations.destroy', $request->id) }}" method="POST" id="deleteForm">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmDelete()">Delete</button>
                            </form>
                        </td>
                      
                    </tr>
                    @endforeach
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
