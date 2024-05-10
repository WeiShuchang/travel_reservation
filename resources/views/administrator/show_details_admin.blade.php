@extends('administrator.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-warning">Approved Reservation Details</h2>
</div>

<div class="bg-success2">
<div class="container-fluid py-2 text-warning " >

    @if($errors->any())     
        <div class="alert alert-danger  ">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



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
                        <h6 >{{ $user->name }}</h6>
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
                        <label for="purpose_of_travel" class="text-yellow font-weight-bold">Purpose of Travel:</label>
                        <h6>{{ $reservation->purpose_of_travel }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="requestor_address" class="text-yellow font-weight-bold">Address (if non-BSU Employee):</label>
                        <h6>{{ $reservation->requestor_address }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="requestor_address" class="text-yellow font-weight-bold">Address (if non-BSU Employee):</label>
                        <h6>{{ $reservation->number_of_passengers }}</h6>
                    </td>
                </tr>
              
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <table class="table table-bordered text-yellow">
            <thead>
                <th colspan='2'>Car</th>
            
            </thead>
            <tbody>
                <tr>
                    <td>  <img  class="img-fluid img-thumbnail" src="{{ asset('storage/cars/' . $car->car_picture) }}" alt="Car Picture"></td>
                </tr>
                <tr>
                    <td> 
                        <h4>Model: <span class="text-white font-weight-bold">{{ $car->model }}</span></h4>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <h4>Make: <span class="text-white font-weight-bold">{{ $car->make }}</span></h4>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <h4>Make: <span class="text-white font-weight-bold">{{ $car->plate_number }}</span></h4>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <h4>Number of Passengers: <span class="text-white font-weight-bold">{{ $reservation->number_of_passengers }}</span></h4>
                    </td>
                </tr>
              

                       
            </tbody>
        </table>
    </div>


    <div class="col-md-4">
        <table class="table table-bordered text-yellow">
            <thead>
                <th class="text-yellow font-weight-bold">Driver</th>
            </thead>
            <tbody>
            <tr>
                <td> <img  class="img-fluid img-thumbnail"src="{{ asset('storage/drivers/' . $driver->driver_picture) }}" alt="Driver Picture"></td>
            </tr>
            <tr>
                <td> 
                    <h4>Name: <span class="text-white font-weight-bold">{{ $driver->driver_name }}</span></h4>
                </td>
            </tr>
            <tr>
                <td> 
                    <h4>Contact #: <span class="text-white font-weight-bold">{{ $driver->contact_number }}</span></h4>
                </td>
            </tr>
            <tr>
                <td> 
                    <h4>Return Date: <span class="text-white font-weight-bold">{{ date('F j, Y', strtotime($reservation->expected_return_date)) }}</span></h4>
                </td>
            </tr>
            <tr>
            <form method="post" action="{{ route('reservation.travel_status_update', $reservation->id) }}" enctype="multipart/form-data" id="updateForm">
                @csrf
                @method("PUT")

                <td> 
                    <h4>Travel Status:</h4>
                    <input type="text" class="form-control" id="travel_status" name="travel_status" value="{{$reservation->travel_status}}" required>
                </td>
            </form>
            </tr>
            <tr>
                <td><button button="button" onclick="confirmApprove()" class="btn btn-success">Edit Travel Status</button></td>
            </tr>
            

            </tbody>
            <tr>
           
        </table>
    </div>
<div>


             
</div>


        
        </div>
    </div>


</div>
</div>

<script>
     
    function confirmApprove() {
        if (confirm("Are you sure you want to Update Travel Status?")) {
            document.getElementById("updateForm").submit();
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
