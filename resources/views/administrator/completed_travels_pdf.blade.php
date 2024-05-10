<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Completed Travels</title>
    <style>
        .logo-left {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        
        .logo-right {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .title {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 24px;
        }
        
        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Border around the whole table */
        }
        
        th, td {
            border: 1px solid #000; /* Borders for table cells */
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2; /* Header background color */
        }

        /* Top center text */
        .top-center {
            text-align: center;
            margin-top: 20px; /* Adjust as needed */
            margin-bottom: 10px; /* Adjust as needed */
            font-weight: bold; /* Adjust as needed */
            font-size: 18px; /* Adjust as needed */
        }
    </style>
</head>
<body>

<!-- Top center text -->
<div class="top-center">
    Republic of the Philippines<br>
    BENGUET STATE UNIVERSITY<br>
    COLLEGE OF INFORMATION SCIENCES<br>
    Department of Information Technology<br>
    2601, La Trinidad, Benguet
</div>

<!-- Title in the center -->
<div class="title">E-Lugan: Completed Travels</div>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th>Requester Name</th>
            <th>Destination</th>
            <th>Departure Date</th>
            <th>Returned Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
        <tr>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->destination }}</td>
            <td>{{ $reservation->date_of_travel }}</td>
            <td>{{ $reservation->expected_return_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
