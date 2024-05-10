@extends('user.base')

@section('content')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


<!-- Add Modal Structure -->
<div class="modal fade" id="successfulReservationModal" tabindex="-1" aria-labelledby="approvedRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="approvedRequestModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Your Reservation Was Completed</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('reservation.show_history')}}" class="btn btn-primary">View</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approvedRequestModal" tabindex="-1" aria-labelledby="approvedRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="approvedRequestModalLabel">Approved Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You Have {{$user_approved_reservations }} Approved Reservation/s</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('reservation.user_approved')}}" class="btn btn-primary">View</a>
            </div>
        </div>
    </div>
</div>


<header class="bg-success" style="height: 100vh;">
    @if(session('success'))
        <div class="alert alert-success" role="alert" id="alert-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container px-5 pt-5">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-5 text-center text-xl-start">
                    <h1 class="display-1 fw-bolder text-yellow mb-2">Welcome  {{ auth()->user()->name }}!</h1>
                    <p class="lead fw-normal text-white-50 mb-4"></p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                        <a class="btn btn-warning btn-lg px-4" href="{{ route('reservation.create') }}">Make A Request</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                <img class="img-fluid rounded-3 my-5" src="{{ asset('home/images/eluganbg.png') }}" alt="...">
            </div>
        </div>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
 $(document).ready(function() {
    // Show Approved Request Modal if there are approved reservations
    let userApprovedRequest = {{ $user_approved_reservations ?? 'false' }};
    if (userApprovedRequest) {
        $('#approvedRequestModal').modal('show');
    }

    // Show Successful Reservation Modal if there are successful reservations
    let userSuccessfulReservations = {{ $user_successful_reservations ?? 'false' }};
    if (userSuccessfulReservations ) {
        $('#successfulReservationModal').modal('show');
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
function showSuccessfulReservationModal() {
    let successfulReservationModalClosed = localStorage.getItem('successfulReservationModalClosed');
    if (!successfulReservationModalClosed) {
        $('#successfulReservationModal').modal('show');
    }
}
</script>

@endsection
