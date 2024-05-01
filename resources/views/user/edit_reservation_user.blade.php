@extends('user.base')

@section('content')

<div class="center bg-success2 pt-3">
    <h2 class="fw-bolder text-warning">Pending Reservation</h2>
</div>

<div class="bg-success2">
<div class="container-fluid py-2 text-warning  vh-100" >

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div >
<div class="row px-3">
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <th class="text-white">Details:</th>
            </thead>
            <tbody>
                
                <tr>
                    <td> 
                        <label for="requestor_name" class="text-yellow font-weight-bold">Requesting Official/Employee/Personnel:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->requestor_name }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="office_department_college" class="text-yellow font-weight-bold">Office/College/Department:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->office_department_college }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="contact_number" class="text-yellow font-weight-bold">Contact Number:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->contact_number }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="appointment_status" class="text-yellow font-weight-bold">Appointment/Contract Status:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->appointment_status }}</h6>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
        <table class="table table-bordered text-yellow">
            <thead>
                <th>Details:</th>
            </thead>
            <tbody>

                <tr>
                    <td> 
                        <label for="destination" class="text-yellow font-weight-bold">Destination:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->destination }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="date_of_travel" class="text-yellow font-weight-bold">Date of Approved Travel:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->date_of_travel }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="purpose_of_travel" class="text-yellow font-weight-bold">Purpose of Travel:</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->purpose_of_travel }}</h6>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="requestor_address" class="text-yellow font-weight-bold">Address (if non-BSU Employee):</label>
                        <h6 class="text-white font-weight-bold">{{ $reservation->requestor_address }}</h6>
                    </td>
                </tr>
                
                
            </tbody>
        </table>

    </div>
</div>
<a href="{{route('reservation.my_reservations')}}" class="btn btn-primary">Back</a>
      
</div>
</div>



<script>
       document.addEventListener("DOMContentLoaded", function() {
        // Function to populate form fields with values from localStorage
        function populateFormFields() {
            // Loop through each input element in the form
            document.querySelectorAll('input').forEach(function(element) {
                // Get the stored value from localStorage using the input element's id attribute
                let storedValue = localStorage.getItem(element.id);
                // If a value is found in localStorage, set the value of the element
                if (storedValue !== null) {
                    element.value = storedValue;
                }
            });
        }

        // Call populateFormFields function when the page is loaded
        populateFormFields();

        // Function to handle form submission
        function handleSubmit(event) {
            // Loop through each input element in the form to store its value in localStorage
            document.querySelectorAll('input').forEach(function(element) {
                // Store the value in localStorage using the input element's id attribute
                localStorage.setItem(element.id, element.value);
            });
        }

        // Attach handleSubmit function to the form submit event
        document.querySelector('form').addEventListener('submit', handleSubmit);
    });
    
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
</script>

@endsection
