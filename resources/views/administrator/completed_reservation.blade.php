@extends('administrator.base')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="bg-success vh-100  align-items-center">

    @if(session('success'))
        <div class="alert alert-success" id="alert-message">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('completed.reservations.search') }}" method="GET" class="py-3 container container-fluid">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" id="quarter" name="quarter">
                    <option value="Q1" @if(request('quarter') == 'Q1') selected @endif>January - March</option>
                    <option value="Q2" @if(request('quarter') == 'Q2') selected @endif>April - June</option>
                    <option value="Q3" @if(request('quarter') == 'Q3') selected @endif>July - September</option>
                    <option value="Q4" @if(request('quarter') == 'Q4') selected @endif>October - December</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="requestor_name" value="{{ request('requestor_name') }}" placeholder="Search by name" value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            <div class=" col-md-3 ">
                <a href="{{ route('completed.reservations.export', ['quarter' => request('quarter')]) }}" class="btn btn-secondary">Export to PDF</a>
            </div>
        </div>
    </form>

    @if($reservations->isEmpty())
        <div class="container alert alert-info mt-3">
            No records found.
        </div>
    @else



    <div class="container  " >
    <div class="mb-3 text-yellow">Number of search results: {{ $reservations->total() }}</div>
        <h2 class="fw-bolder text-primary pt-2">Completed Travel: </h2>

        <div class="table-responsive ">
            <!-- Table for Request Listing -->
            <table class="table table-bordered text-white bg-success2  pb-5">
                <thead>
                    <tr>
  
                        <th class="text-yellow">Requester Name</th>
                        <th class="text-yellow">Destination</th>
                        <th class="text-yellow">Departure Date</th>
                        <th class="text-yellow">Returned Date</th>
                        
                        <th class="text-yellow">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data - Replace with Laravel Blade syntax -->
                    @foreach($reservations as $request)
                    <tr>

                        <td>{{ $request->requestor_name }}</td>
                        <td>{{ $request->destination }}</td>
                        <td>{{ $request->date_of_travel }}</td>
                        <td>{{ $request->expected_return_date }}</td>
                      
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
        @endif
</div>
    
</div>


<div class="col-md-12  bg-success ">
    <div class="container py-4">
        {{ $reservations->appends(request()->query())->links('vendor.pagination.default') }}
    </div>
</div>

<div>
<div class="bg-success">
    <div class="container text-center  text-yellow bg-light" style="width: 60%">
        <canvas id="barChart" width="200" height="100" class="text-yellow"></canvas>
    </div>
</div>

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

     // Access the data passed from the controller
     var chartData = {!! json_encode($chartData) !!};
 // Access the data passed from the controller
 var chartData = {!! json_encode($chartData) !!};

// Prepare data for Chart.js
var labels = Object.keys(chartData);
var data = Object.values(chartData);

// Create the bar chart
var ctx = document.getElementById('barChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Number of Reservations',
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    fontSize: 10
                }
            }],
            xAxes: [{
                ticks: {
                    fontSize: 10
                }
            }]
        }
    }
});
   
  
</script>

@endsection
