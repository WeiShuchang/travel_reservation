@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-warning">Approve Reservation</h2>
</div>

<div class="bg-success2">
<div class="container-fluid py-2 text-warning" >

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
    <div class="row px-3">
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead>
                    <th class="text-yellow">Details:</th>
                </thead>
                <tbody>
                    
                    <tr>
                        <td> 
                            <label for="requestor_name" class="text-yellow font-weight-bold">Requesting Official/Employee/Personnel:</label>
                            <input value="{{ $reservation->requestor_name }}" type="text" class="form-control form-control-sm" id="requestor_name" name="requestor_name" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="office_department_college" class="text-yellow font-weight-bold">Office/College/Department:</label>
                            <input value="{{ $reservation->office_department_college }}" type="text" class="form-control form-control-sm" id="office_department_college" name="office_department_college" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="contact_number" class="text-yellow font-weight-bold">Contact Number:</label>
                            <input value="{{ $reservation->contact_number }}" type="number" class="form-control form-control-sm" id="contact_number" name="contact_number" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="appointment_status" class="text-yellow font-weight-bold">Appointment/Contract Status:</label>
                            <input value="{{ $reservation->appointment_status }}" type="text" class="form-control form-control-sm" id="appointment_status" name="appointment_status" required>
                        </td>
                    </tr>
                   
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <table class="table table-bordered text-yellow">
                <thead>
                    <th>Details:</th>
                </thead>
                <tbody>

                    <tr>
                        <td> 
                            <label for="destination" class="text-yellow font-weight-bold">Destination:</label>
                            <input value="{{ $reservation->destination }}" type="text" class="form-control form-control-sm" id="destination" name="destination" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="date_of_travel" class="text-yellow font-weight-bold">Date of Approved Travel:</label>
                            <input value="{{ $reservation->date_of_travel }}" type="date" class="form-control form-control-sm" id="date_of_travel" name="date_of_travel" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="purpose_of_travel" class="text-yellow font-weight-bold">Purpose of Travel:</label>
                            <input value="{{ $reservation->purpose_of_travel }}" type="text" class="form-control form-control-sm" id="purpose_of_travel" name="purpose_of_travel" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="requestor_address" class="text-yellow font-weight-bold">Address (if non-BSU Employee):</label>
                            <input value="{{ $reservation->requestor_address }}" type="text" class="form-control form-control-sm" id="requestor_address" name="requestor_address">
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
                            <label for="number_of_passengers" class="text-yellow font-weight-bold ">Number of Passengers Needed:</label>
                            <input value="{{ $reservation->number_of_passengers }}" type="text" class="form-control form-control-sm" id="number_of_passengers" name="number_of_passengers" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="driver" class="text-yellow font-weight-bold">Assign Driver:</label>
                            <select name="driver_id" id="" class="px-3 py-1">
                                @foreach ($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->driver_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="car" class="text-yellow font-weight-bold">Assign Car:</label>
                            <select name="car_id" id=""  class="px-3 py-1">
                                @foreach ($cars as $car)
                                    <option value="{{$car->id}}">{{$car->make}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <label for="expected_return_date" class="text-yellow font-weight-bold">Expected Return Date:</label>
                            <input type="date" class="form-control form-control-sm" id="expected_return_date" name="expected_return_date" required>
                        </td>
                    </tr>

                    <tr>
                        <td> 
                            <div class="mx-3">
                                <button button="button" onclick="confirmDelete()" class="btn btn-success">Approve Reservation</button>
                                <a href="{{ route('reservation.index') }}" class="my-1 btn btn-warning">Cancel</a>
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

<script>
    function confirmDelete() {
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
</script>

@endsection
