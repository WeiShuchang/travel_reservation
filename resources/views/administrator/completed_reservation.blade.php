@extends('administrator.base')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-success vh-100 align-items-center">

    @if(session('success'))
    <div class="alert alert-success" id="alert-message">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('completed.reservations.search') }}" method="GET"
        class="py-3 container container-fluid">
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
                <input type="text" class="form-control" name="user_name"
                    value="{{ request('user_name') }}" placeholder="Search by name">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('completed.reservations.export', ['quarter' => request('quarter')]) }}"
                    class="btn btn-secondary">Export to PDF</a>
            </div>
        </div>
    </form>

    @if($reservations->isEmpty())
    <div class="container alert alert-info mt-3">
        No records found.
    </div>
    @else
    <div class="container">
        <div class="mb-3 text-yellow">Number of search results: {{ $reservations->total() }}</div>
        <h2 class="fw-bolder text-primary pt-2">Completed Travel: </h2>

        <div class="table-responsive">
            <!-- Table for Request Listing -->
            <table class="table table-bordered text-white bg-success2 pb-5">
                <thead>
                    <tr>
                        <th class="text-yellow">Requester Name</th>
                        <th class="text-yellow">Days of Travel</th>
                        <th class="text-yellow">Driver</th>
                        <th class="text-yellow">Car Plate Number</th>
                        <th class="text-yellow">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data - Replace with Laravel Blade syntax -->
                    @foreach($reservations as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->date_of_travel)->diffInDays(\Carbon\Carbon::parse($request->expected_return_date)) }}</td>
                        <td>
                            @if ($request->driver)
                                {{ $request->driver->driver_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ($request->car)
                                {{ $request->car->plate_number }}
                            @else
                                N/A
                            @endif
                        </td>
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
    @endif

</div>

</div>

<div class="col-md-12 bg-success">
    <div class="container py-4">
        {{ $reservations->appends(request()->query())->links('vendor.pagination.default') }}
    </div>
</div>

<div>
    <div class="bg-success">
        <div class="container text-center text-yellow bg-light" style="width: 60%">
            <canvas id="barChart" width="200" height="100" class="text-yellow"></canvas>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to Delete This Reservation?")) {
            document.getElementById("deleteForm").submit();
        } else {
            event.preventDefault();
        }
    }

    // Ensure the DOM is loaded before accessing elements
    document.addEventListener("DOMContentLoaded", function () {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");

        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function () {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000);
    });

    let cars = {!! json_encode($cars) !!};
    let reservationsCount = {!! json_encode($reservationsCount) !!};

    let ctx = document.getElementById('barChart').getContext('2d');
    let barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: cars,
            datasets: [{
                label: 'Number of Reservations',
                data: reservationsCount,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Reservations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Car Plate Number'
                    }
                }
            }
        }
    });
    
</script>

@endsection
