@extends('user.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-yellow">Travel Request Form</h2>
</div>

<div class="bg-success2">
    <div class="container py-2 text-white">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <form method="post" action="{{ route('reservation.store') }}" enctype="multipart/form-data" id="reserveForm">
            @csrf

            <div class="row">
                
                <div class="form-group col-md-6">
                    <label for="office_department_college" class="text-yellow font-weight-bold">Office/College/Department:</label>
                    <input type="text" class="form-control" id="office_department_college" name="office_department_college" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="contact_number" class="text-yellow font-weight-bold">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="appointment_status" class="text-yellow font-weight-bold">Appointment/Contract Status:</label>
                    <select class="form-control" id="appointment_status" name="appointment_status" required>
                        <option value="Permanent">Permanent</option>
                        <option value="Contractual">Contractual</option>
                        <option value="Substitute">Substitute</option>
                        <option value="Job-Order">Job-Order</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="requestor_address" class="text-yellow font-weight-bold">Requestor Address:</label>
                    <input type="text" class="form-control" id="requestor_address" name="requestor_address">
                </div>
                <div class="form-group col-md-6">
                    <label for="number_of_passengers" class="text-yellow font-weight-bold">Number of Passengers:</label>
                    <input type="number" class="form-control" id="number_of_passengers" name="number_of_passengers" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="destination" class="text-yellow font-weight-bold">Destination:</label>
                    <input type="text" class="form-control" id="destination" name="destination" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="date_of_travel" class="text-yellow font-weight-bold">Date of Travel:</label>
                    <input type="date" class="form-control" id="date_of_travel" name="date_of_travel" required>
                </div>
                <div  class="form-group col-md-6">
                    <label for="expected_return_date" class="text-yellow font-weight-bold">Expected Return Date:</label>
                    <input type="date" class="form-control" id="expected_return_date" name="expected_return_date" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="purpose_of_travel" class="text-yellow font-weight-bold">Purpose of Travel:</label>
                    <input type="text" class="form-control" id="purpose_of_travel" name="purpose_of_travel" required>
                </div>


                <div class="form-group col-md-6 mt-4">
                    <button type="submit" class="btn btn-success col-md-3" onclick="confirmReservation()">Submit Details</button>
                    <a href="{{ route('user') }}" class="my-2 btn btn-warning col-md-3">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Ensure the DOM is loaded before accessing elements
document.addEventListener("DOMContentLoaded", function() {
    // Get the alert message element
    let alertMessage = document.getElementById("alert-message");
    
    // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
    setTimeout(function() {
        // Hide the alert by changing its display style to "none"
        alertMessage.style.display = "none";
    }, 4000); 

    // Retrieve form data from local storage if available
    let formData = JSON.parse(localStorage.getItem('formData'));
    if (formData) {
        // Loop through form inputs and set their values
        let form = document.getElementById("reserveForm");
        let inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="date"], textarea, select');
        
        inputs.forEach(function(input) {
            if (formData[input.name]) {
                input.value = formData[input.name];
            }
        });
    }
});

function confirmReservation() {
    // Check if all fields are filled
    var form = document.getElementById("reserveForm");
    var inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="date"], textarea, select');
    
    let formData = {};

    for (var i = 0; i < inputs.length; i++) {
        if (!inputs[i].value.trim()) {
            alert("Please fill in all fields.");
            return false;
        }
        // Store input values in formData object
        formData[inputs[i].name] = inputs[i].value;
    }

    // Save form data to local storage
    localStorage.setItem('formData', JSON.stringify(formData));

    // If all fields are filled, confirm submission
    if (confirm("Are you sure you want to Submit This Reservation?")) {
        form.submit();
    } else {
        event.preventDefault(); 
    }
}


    $(document).ready(function() {
        $('#appointment_status').change(function() {
            if ($(this).val() === 'Others') {
                $('#other_appointment_status').show();
            } else {
                $('#other_appointment_status').hide();
            }
        });
    });


  
</script>

@endsection
