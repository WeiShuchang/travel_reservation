<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Car;
use App\Models\Driver;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{

    // Display a listing of the reservations.
    public function index()
    {
        $reservations = Reservation::where('is_approved', false)
            ->where('is_successful', false)
            ->where('is_cancelled', false)
            ->latest()
            ->paginate(4);
    
        return view('administrator.user_reservations', compact('reservations'));
    }    

    // Show the form for creating a new reservation.
    public function create()
    {
        return view('user.reservation');
    }




    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'requestor_name' => 'required|string|max:255',
                'office_department_college' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'appointment_status' => 'required|string|max:255',
                'requestor_address' => 'nullable|string|max:255',
                'number_of_passengers' => 'required|integer|min:1',
                'destination' => 'required|string|max:255',
                'date_of_travel' => ['required', 'date', 'after_or_equal:today'], // Check if date is today or in the future
                'purpose_of_travel' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $validatedData = $validator->validated();
            $validatedData['user_id'] = Auth::id();
    
            // Check if the record already exists
            $existingReservation = Reservation::where('requestor_name', $validatedData['requestor_name'])
            ->where('destination', $validatedData['destination'])
            ->where('date_of_travel', $validatedData['date_of_travel'])
            ->where('is_approved', false)
            ->where('is_successful', false)
            ->where('is_cancelled', false)
            ->exists();

    
            if ($existingReservation) {
                return redirect()->back()->with('error', 'This reservation already exists.');
            }
    
            // Create the reservation
            Reservation::create($validatedData);
    
            return redirect()->route('user')->with('success', 'Reservation created successfully.');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            // Handle database query exceptions
            if ($e->errorInfo[1] === 1062) { // MySQL error code for duplicate entry violation
                return redirect()->back()->with('error', 'Duplicate entry found. Please try again.');
            }
            
            return redirect()->back()->with('error', 'Failed to create reservation. Please try again.');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Failed to create reservation. Please try again.');
        }
    }
    

    public function show_details($id)
    {
        $reservation = Reservation::findOrFail($id);
        $driver = $reservation->driver;
        $car = $reservation->car;

        return view('user.user_reservation_details', compact('reservation', 'driver', 'car'));
    }

    // Show the form for editing the specified reservation.
    public function edit($reservation_id)
    {   
        $cars = Car::where('car_status', 'available')->get();
        $drivers = Driver::where('driver_status', 'available')->get();        
        $reservation = Reservation::findOrFail($reservation_id);
        return view('administrator.edit_reservation', compact('reservation','cars','drivers'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        // Validate only the fields you want to update
        $validatedData = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'car_id' => 'required|exists:cars,id',
            'expected_return_date' => ['required', 'date', 'after_or_equal:today'],
            'number_of_passengers' => 'required|integer|min:1',
        ]);
    
        // Update the reservation with the validated data
        $reservation->update($validatedData);
    
        // Set is_approved to true
        $reservation->is_approved = true;
        $reservation->save();
    
        // Retrieve the driver and car associated with the reservation
        $driver = $reservation->driver;
        $car = $reservation->car;
    
        // Set driver status to "unavailable"
        $driver->driver_status = 'unavailable';
        $driver->save();
    
        // Set car status to "unavailable"
        $car->car_status = 'unavailable';
        $car->save();
    
        return redirect()->route('reservation.index')
            ->with('success', 'Reservation Has Been Approved!');
    }
    
    // Remove the specified reservation from storage.
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->back()
            ->with('success', 'Reservation deleted successfully.');
    }


    public function approved(Reservation $reservation)
    {
        $reservations = Reservation::where('is_approved', true)
            ->where('is_successful', false)
            ->where('is_cancelled', false)
            ->latest()
            ->paginate(5);

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('administrator.approved_reservations', compact('reservations'));
    }

    public function show_cancelled(Reservation $reservation){
        $reservations = Reservation::where('is_cancelled', true)
            ->latest()
            ->paginate(10);

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('administrator.cancelled_reservation', compact('reservations'));
        
    }

    public function show_completed(Reservation $reservation)
    {
        $reservations = Reservation::where('is_successful', true)
            ->latest()
            ->paginate(7);
    
        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        // Fetch or prepare $chartData here
        $chartData = 0; // Example method to fetch or prepare $chartData
    
        // Pass $chartData to the view only if it's available
        if (isset($chartData)) {
            return view('administrator.completed_reservation', compact('reservations', 'chartData'));
        } else {
            return view('administrator.completed_reservation', compact('reservations'));
        }
    }
    

    public function cancel(Reservation $reservation)
    {
        // Set is_cancelled attribute to true
        $reservation->update(['is_cancelled' => true]);
        $reservation->update(['is_approved' => false]);
        $reservation->update(['is_successful' => false]);

        $driver = $reservation->driver;
        $car = $reservation->car;

        if ($driver) {
            $driver->update(['driver_status' => 'available']);
        }
        if ($car) {
            $car->update(['car_status' => 'available']);
        }
    
        return redirect()->back()
            ->with('success', 'Reservation cancelled successfully.');
    }

    public function complete(Reservation $reservation)
    {
        // Set is_cancelled attribute to true
        $reservation->update(['is_cancelled' => false]);
        $reservation->update(['is_approved' => false]);
        $reservation->update(['is_successful' => true]);

        $driver = $reservation->driver;
        $car = $reservation->car;
    
        // Update driver and car statuses
        if ($driver) {
            $driver->update(['driver_status' => 'available']);
        }
        if ($car) {
            $car->update(['car_status' => 'available']);
        }
    
        return redirect()->back()
            ->with('success', 'Reservation completed successfully.');
    }

    public function my_reservations()
    {
        $user = auth()->user();

        // Retrieve reservations associated with the current user
        $reservations = Reservation::where('user_id', $user->id)
        ->where('is_approved', false)
        ->where('is_cancelled', false)
        ->where('is_successful', false)
        ->paginate(4);

        // Pass the reservations data to the view
        return view('user.my_reservations', ['reservations' => $reservations]);
    }

    public function show_available()
    {
        // Retrieve all available cars and drivers
        $available_cars = Car::where('car_status', 'available')->get();
        $unavailable_cars = Car::where('car_status', 'unavailable')->get();
        $available_drivers = Driver::where('driver_status', 'available')->get();
        $unavailable_drivers = Driver::where('driver_status', 'unavailable')->get();

    
        // Pass the available cars and drivers data to the view
        return view('user.availability', compact('available_cars', 'available_drivers', 'unavailable_cars', 'unavailable_drivers'));
    }
    public function search(Request $request){
        $quarter = $request->input('quarter'); // Assuming 'quarter' is a parameter passed from the frontend
        $requestorName = $request->input('requestor_name'); // Get the requestor_name parameter from the request
    
        // Determine the date range based on the selected quarter
        $startDate = null;
        $endDate = null;
    
        if ($quarter == 'Q1') {
            $startDate = '01-01';
            $endDate = '03-31';
        } elseif ($quarter == 'Q2') {
            $startDate = '04-01';
            $endDate = '06-30';
        } elseif ($quarter == 'Q3') {
            $startDate = '07-01';
            $endDate = '09-30';
        } elseif ($quarter == 'Q4') {
            $startDate = '10-01';
            $endDate = '12-31';
        }
    
        $query = Reservation::where('is_successful', true)
        ->whereBetween(DB::raw("DATE_FORMAT(date_of_travel, '%m-%d')"), [$startDate, $endDate]);

        // Apply requestor name filter if provided
        if (!empty($requestorName)) {
        $query->where('requestor_name', 'LIKE', '%' . $requestorName . '%');
        }

        // Perform search on reservations based on the selected quarter and requestor name
        $reservations = $query->latest()->paginate(7); // Paginate the search results
    
        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }

        $reservationCounts = Reservation::where('is_successful', true)
        ->selectRaw("CASE 
                        WHEN MONTH(date_of_travel) BETWEEN 1 AND 3 THEN 'January - March'
                        WHEN MONTH(date_of_travel) BETWEEN 4 AND 6 THEN 'April - June'
                        WHEN MONTH(date_of_travel) BETWEEN 7 AND 9 THEN 'July - September'
                        ELSE 'October - December'
                     END as quarter_range,
                     COUNT(*) as count")
        ->groupBy(DB::raw("CASE 
                    WHEN MONTH(date_of_travel) BETWEEN 1 AND 3 THEN 'January - March'
                    WHEN MONTH(date_of_travel) BETWEEN 4 AND 6 THEN 'April - June'
                    WHEN MONTH(date_of_travel) BETWEEN 7 AND 9 THEN 'July - September'
                    ELSE 'October - December'
                    END"))
        ->get();
    
    
        // Prepare data for the bar chart
        $chartData = [];
        $quarters = ['January - March', 'April - June', 'July - September', 'October - December'];
        
        // Initialize with all quarters and zero count
        foreach ($quarters as $range) {
            $chartData[$range] = 0;
        }
        
        // Populate counts for quarters with records
        foreach ($reservationCounts as $count) {
            $chartData[$count->quarter_range] = $count->count;
        }
    
            // Pass data to the view
            return view('administrator.completed_reservation', compact('reservations', 'quarter', 'chartData'));
        }


        
        public function exportCompletedTravels(Request $request)
        {
            $quarter = $request->input('quarter'); // Get the quarter from the request
        
            // Determine the date range based on the selected quarter
            $startDate = null;
            $endDate = null;
        
            if ($quarter == 'Q1') {
                $startDate = '01-01';
                $endDate = '03-31';
            } elseif ($quarter == 'Q2') {
                $startDate = '04-01';
                $endDate = '06-30';
            } elseif ($quarter == 'Q3') {
                $startDate = '07-01';
                $endDate = '09-30';
            } elseif ($quarter == 'Q4') {
                $startDate = '10-01';
                $endDate = '12-31';
            }
        
            // Retrieve reservations data based on the selected quarter
            $reservations = Reservation::where('is_successful', true)
                ->whereBetween(DB::raw("DATE_FORMAT(date_of_travel, '%m-%d')"), [$startDate, $endDate])
                ->latest()
                ->get();
        
            // Prepare data for the bar chart
            $chartData = $this->prepareChartData($quarter);
        
            // Instantiate Dompdf
            $pdf = new Dompdf();
        
            // Load HTML content for the PDF
            $html = view('administrator.completed_travels_pdf', compact('reservations', 'chartData'))->render();
        
            // Load HTML into Dompdf
            $pdf->loadHtml($html);
        
            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');
        
            // Render the PDF
            $pdf->render();
        
            // Output the generated PDF
            return $pdf->stream('completed_travels.pdf');
        }
        
        private function prepareChartData($quarter)
        {
            // Prepare data for the bar chart
            $chartData = [];
            $reservations = Reservation::where('is_successful', true)->get();
        
            // Determine the date range based on the selected quarter
            $startDate = null;
            $endDate = null;
        
            if ($quarter == 'Q1') {
                $startDate = '01-01';
                $endDate = '03-31';
            } elseif ($quarter == 'Q2') {
                $startDate = '04-01';
                $endDate = '06-30';
            } elseif ($quarter == 'Q3') {
                $startDate = '07-01';
                $endDate = '09-30';
            } elseif ($quarter == 'Q4') {
                $startDate = '10-01';
                $endDate = '12-31';
            }
        
            // Count the number of reservations per quarter
            $reservationCounts = $reservations->whereBetween('date_of_travel', [$startDate, $endDate])->count();
        
            // Prepare data for the bar chart
            $chartData['Quarterly'] = $reservationCounts;
        
            return $chartData;
        }
    
    public function user_approved(Reservation $reservation)
    {
        $user = Auth::user();

        $reservations = Reservation::where('is_approved', true)
            ->where('is_successful', false)
            ->where('is_cancelled', false)
            ->latest()
            ->paginate(5);

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('user.user_approved_request', compact('reservations'));
    }

    public function modalClosed(Request $request)
    {
        // Set a session variable indicating the modal has been closed
        Session::put('approved_request', false);

        return response()->json(['status' => 'success']);
    }

    public function edit_for_user($reservation_id)
    {   
        $cars = Car::where('car_status', 'available')->get();
        $drivers = Driver::where('driver_status', 'available')->get();        
        $reservation = Reservation::findOrFail($reservation_id);
        return view('user.edit_reservation_user', compact('reservation','cars','drivers'));
    }


    public function show_history()
    {
        $reservations = Reservation::where('is_successful', true)
            ->latest()
            ->paginate(6);

        return view('user.travel_history', compact('reservations'));
    }    

        // Function to update a reservation
    public function reservation_update_user(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'requestor_name' => 'required|string',
            'office_department_college' => 'required|string',
            'contact_number' => 'required|string',
            'appointment_status' => 'required|string',
            'destination' => 'required|string',
            'date_of_travel' => 'required|date|after_or_equal:today',
            'purpose_of_travel' => 'required|string',
            'requestor_address' => 'nullable|string',
        ], [
            'date_of_travel.after_or_equal' => 'The date of travel must be after or on today.',
        ]);

        // Find the reservation by its ID
        $reservation = Reservation::findOrFail($id);

        // Update the reservation with the validated data
        $reservation->update($validatedData);

        // Redirect back to a page, or return a response
        return redirect()->route('reservation.my_reservations', $reservation->id)->with('success', 'Reservation updated successfully');
    }


    private function getQuarterName($quarterNumber) {
        $quarters = [
            1 => 'Q1',
            2 => 'Q2',
            3 => 'Q3',
            4 => 'Q4'
        ];
    
        return $quarters[$quarterNumber];
    }
}
