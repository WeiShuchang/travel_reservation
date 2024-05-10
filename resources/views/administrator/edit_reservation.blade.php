@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-warning">Approve Reservation</h2>
</div>
<!-- Add this modal HTML structure to your view -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-success">
        <div class="modal-content bg-success2 text-warning">
            <form method="post" id="cancelForm" action="{{ route('reservation.cancel', $reservation->id) }}" enctype="multipart/form-data" >
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

<div class="bg-success2">
<div class="container-fluid py-2 text-warning  vh-100" >

    @if($errors->any())     
        <div class="alert alert-danger  ">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<form method="post" action="{{ route('reservation.update', $reservation->id) }}" enctype="multipart/form-data" id="deleteForm">
    @csrf
    @method("PUT")
<div class="row ">
    <div class="col-md-4">
        <table class="table table-bordered text-white">
            <thead>
                <th class="text-yellow">Details:</th>
            </thead>
            <tbody>
                <tr>
                    <td> 
                        <label for="requestor_name" class="text-yellow font-weight-bold">Requesting Official/Employee/Personnel:</label>
                        <h6 >{{ $reservation->user->name }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="office_department_college" class="text-yellow font-weight-bold">Office/College/Department:</label>
                        <h6 class="text-white">{{ $reservation->office_department_college }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="contact_number" class="text-yellow font-weight-bold">Contact Number:</label>
                        <h6>{{ $reservation->contact_number }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="appointment_status" class="text-yellow font-weight-bold">Appointment/Contract Status:</label>
                        <h6>{{ $reservation->appointment_status }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="requestor_address" class="text-yellow font-weight-bold">Address (if non-BSU Employee):</label>
                        <h6>{{ $reservation->requestor_address }}</h6>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <table class="table table-bordered text-white">
            <thead>
                <th class="text-yellow font-weight-bold">Details:</th>
            </thead>
            <tbody>
                <tr>
                    <td> 
                        <label for="destination" class="text-yellow font-weight-bold">Destination:</label>
                        <h6>{{ $reservation->destination }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="date_of_travel" class="text-yellow font-weight-bold">Date of Approved Travel:</label>
                        <h6>{{ $reservation->date_of_travel }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="date_of_travel" class="text-yellow font-weight-bold">Expected Return Date:</label>
                        <h6>{{ $reservation->expected_return_date }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="purpose_of_travel" class="text-yellow font-weight-bold">Purpose of Travel:</label>
                        <h6>{{ $reservation->purpose_of_travel }}</h6>
                    </td>
                </tr>
               
            </tbody>
        </table>
    </div>



        <div class="col-md-4">
            <table class="table table-bordered text-yellow">
                <thead>
                    <th>Assign Driver and Car</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label for="number_of_passengers" class="text-yellow font-weight-bold">Number of Passengers Needed:</label>
                        <input type="number" name="number_of_passengers" id="number_of_passengers" class="form-control form-control-sm" value="{{ old('number_of_passengers', $reservation->number_of_passengers) }}">

                    </td>
                </tr>

                    <tr>
                        <td> 
                            <label for="driver" class="text-yellow font-weight-bold">Assign Driver:</label>
                            <select name="driver_id" id="driver_id" class="px-3 py-1">
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id', $reservation->driver_id) == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->driver_name }}
                                    </option>
                                @endforeach
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="car" class="text-yellow font-weight-bold">Assign Car:</label>
                            <select name="car_id" id="car_id" class="px-3 py-1">
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}" {{ old('car_id', $reservation->car_id) == $car->id ? 'selected' : '' }}>
                                        {{ $car->make }} | {{ $car->plate_number }}
                                    </option>
                                @endforeach
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="travel_status" class="text-yellow font-weight-bold">Travel Status:</label>
                            <input type="text" class="form-control" id="travel_status" name="travel_status" value="{{$reservation->travel_status}}" >
                        </td>
                    </tr>
               
                    <tr>
                        <td> 
                            <div class="mx-3">
                                <button button="button" onclick="confirmApprove()" class="btn btn-success">Approve Reservation</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                    Cancel Reservation
                                </button>
                            </div>
                            
                        </td>
                    </tr>
                    
                            
                </tbody>
            </table>
                
            </div>
        </div>
    </div>

    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmApprove() {
        if (confirm("Are you sure you want to Approve Reservation?")) {
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
</script>

@endsection
