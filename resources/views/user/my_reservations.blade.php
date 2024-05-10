@extends('user.base')

@section('content')



<div class="center bg-success2 pt-3" id="cars">
    <h1 class="fw-bolder text-yellow">Pending Reservations</h1>
</div>

<div class="modal fade" id="cancelledReservationModal" tabindex="-1" aria-labelledby="approvedRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="approvedRequestModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Your Reservation Was Cancelled</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('reservation.show_user_cancelled')}}" class="btn btn-primary">View</a>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid bg-success2 vh-100">
    @if(session('success'))
        <div class="alert alert-success" role="alert" id="alert-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-success2 row justify-content-start ml-3 pl-3">
    @if (!empty($num_pending_reservations) )
        @foreach ($reservations as $reservation)
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-success">
        <div class="modal-content bg-success2 text-warning">
            <form method="post" id="cancelForm" action="{{ route('reservation.cancel_for_user', $reservation->id) }}" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason_for_cancel" class="form-label">Reason for Cancellation:</label>
                        <textarea class="form-control" id="reason_for_cancel" name="reason_for_cancel" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="confirmCancel()" class="btn btn-danger">Cancel Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
        <div class="card mx-2 col-md-3 mt-4 mb-4 bg-success text-white" style="width: 19rem;">
            <div class="card-body"  onclick="location.href='{{ route('reservation.edit_for_user', $reservation->id) }}'">
                <div class="row">
                    <div class="col-md-8">
                        <span class="badge badge-primary mb-2">Pending</span>
                        <h6 class="card-title font-weight-bold">Reservation by:</h6>
                        <h5 class="card-title text-warning font-weight-bolder">{{ $reservation->user->name }}</h5>
                        <h6 class="card-title font-weight-bold mt-4">Reason for Travel:</h6>
                        <h6 class="card-title text-warning font-weight-bolder">{{ $reservation->purpose_of_travel }}</h6>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ asset('home/images/eluganbg.png') }}" height="70px" width="70px" alt="eluganbg" style="border-radius:50%;">
                    </div>
                </div>
                <p class="card-text">
                    <ul>
                        <li class="font-weight-bold">Number of Passengers:</li>
                        <p class="text-warning">{{ $reservation->number_of_passengers }}</p>
                        <li class="font-weight-bold">Destination:</li>
                        <p class="text-warning">{{ $reservation->destination }}</p>
                        <li class="font-weight-bold">Date of Travel:</li>
                        <p class="text-warning">{{ $reservation->date_of_travel }}</p>
                    </ul>
                </p>
            </div>
            <div class="row p-3">
            <div class="col-md-12">
            <div class="row">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                Cancel Reservation
            </button>
</div>
        </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="card mx-2 col-md-3 mt-4 mb-4 bg-success text-white" style="width: 19rem;">
            <div class="card-body ">
                <div class="row">
                    <h3 class="card-title font-weight-bold my-3 text-warning">No Existing Requests</h3>
                </div>
            </div>
        </div>
        @endif
   
    </div>

</div>

                
<div class="col-md-12 bg-success py-2">
    {{ $reservations->links('vendor.pagination.default') }}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this request?")) {
            document.getElementById("deleteForm").submit();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let alertMessage = document.getElementById("alert-message");
        setTimeout(function() {
            alertMessage.style.display = "none";
        }, 4000);
    });
     // Function to handle cancellation form submission confirmation
     function confirmCancel() {
        if (confirm("Are you sure you want to cancel this reservation?")) {
            // Submit the form if confirmed
            document.getElementById("cancelForm").submit();
        } else {
            // Prevent form submission if not confirmed
            event.preventDefault();
        }
    }
 $(document).ready(function() {


    // Show Successful Reservation Modal if there are successful reservations
    let userCancelledReservations = {{ $user_cancelled_reservations ?? 'false' }};
    if (userCancelledReservations ) {
        $('#cancelledReservationModal').modal('show');
    }

    // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
    setTimeout(function() {
        $('#alert-message').fadeOut();
        $('#approvedRequestModal').fadeOut();
    }, 4000); 

    // Handle Successful Reservation Modal Close Event
    $('#successfulReservationModalClose').click(function() {
        localStorage.setItem('successfulReservationModalClosed', true);
    });
});

// Function to handle showing the successful reservation modal again if there's a new successful reservation
function showCancelledReservationModal() {
    let successfulReservationModalClosed = localStorage.getItem('successfulReservationModalClosed');
    if (!successfulReservationModalClosed) {
        $('#cancelledReservationModal').modal('show');
    }
}
</script>


@endsection
