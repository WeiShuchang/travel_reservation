@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3" id="cars">
    <h1 class="fw-bolder text-yellow">TRAVEL REQUESTS</h1>
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

        <div class="card mx-2 col-md-3 mt-4 mb-4 bg-success text-white" style="width: 19rem;" >
            <div class="card-body" onclick="location.href='{{ route('reservation.edit', $reservation->id) }}'">
                <div class="row">
                    <div class="col-md-8">
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
            {{--<div class="col-md-12 pb-4 d-flex justify-content-center">
                <form class="" action="{{ route('reservations.destroy', $reservation->id ) }}" method="post" id="deleteForm">
                    @csrf
                    @method("DELETE")
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Reservation</button>
                </form>
            </div>--}}


        </div>
       
        @endforeach
        @else
        <div class="card mx-2 col-md-3 mt-4 mb-4 bg-success text-white" style="width: 19rem;">
            <div class="card-body ">
                <div class="row">
                    <h3 class="card-title font-weight-bold mt-3 text-warning">No Existing Reservations</h3>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


<div class="col-md-12 bg-success py-2">
    {{ $reservations->links('vendor.pagination.default') }}
</div>


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
</script>

@endsection
