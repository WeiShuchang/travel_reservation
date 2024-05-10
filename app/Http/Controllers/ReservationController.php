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

    // checked
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
                'office_department_college' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'appointment_status' => 'required|string|max:255',
                'requestor_address' => 'nullable|string|max:255',
                'number_of_passengers' => 'required|integer|min:1',
                'destination' => 'required|string|max:255',
                'date_of_travel' => ['required', 'date', 'after_or_equal:today'],
                'expected_return_date' => ['required', 'date', 'after_or_equal:today'], // Check if date is today or in the future
                'purpose_of_travel' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $validatedData = $validator->validated();
        
            $validatedData['user_id'] = Auth::user()->id;
    
                 // Check if the user has existing reservations for the same destination and date
                $existingReservation = Reservation::where('user_id', $validatedData['user_id'])
                ->where('destination', $validatedData['destination'])
                ->where('date_of_travel', $validatedData['date_of_travel'])
                ->where('is_approved', false)
                ->where('is_successful', false)
                ->where('is_cancelled', false)
                ->exists();

            if ($existingReservation) {
                return redirect()->back()->with('error', 'You already have a reservation for this destination on this date.');
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
    
    
    //checked
    public function show_details($id)
    {
        $reservation = Reservation::findOrFail($id);
        $driver = $reservation->driver;
        $car = $reservation->car;
        $user = $reservation->user;

        return view('user.user_reservation_details', compact('reservation', 'driver', 'car', 'user'));
    }

    public function show_details_admin($id)
    {
        $reservation = Reservation::findOrFail($id);
        $driver = $reservation->driver;
        $car = $reservation->car;
        $user = $reservation->user;

        return view('administrator.show_details_admin', compact('reservation', 'driver', 'car', 'user'));
    }


    //checked
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
            'number_of_passengers' => 'required|integer|min:1',
            'travel_status' => 'required|string|max:50',
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

    //checked
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

    //checked
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

    //checked
    public function show_completed()
    {
        $reservations = Reservation::where('is_successful', true)
            ->latest()
            ->paginate(10);
        
        // Fetch or prepare $chartData here
        $chartData = 0; 
        $cars = 0;
        $reservationsCount = 0;
    
        // Pass $chartData to the view only if it's available
        if (isset($chartData)) {
            return view('administrator.completed_reservation', compact('reservations', 'chartData', 'cars', 'reservationsCount'));
        } else {
            return view('administrator.completed_reservation', compact('reservations', 'cars', 'reservationsCount'));
        }
        
    }
    
    public function cancel_reservation(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reason_for_cancel' => 'required|string|max:255', // Validation rule for the cancellation reason
        ]);
    
        $reservation->update([
            'is_cancelled' => true,
            'is_approved' => false,
            'is_successful' => false,
            'reason_for_cancel' => $request->input('reason_for_cancel'), // Store the reason for cancellation
        ]);
    
        $driver = $reservation->driver;
        $car = $reservation->car;
    
        if ($driver) {
            $driver->update(['driver_status' => 'available']);
        }
        if ($car) {
            $car->update(['car_status' => 'available']);
        }
    
        // Determine user's role
        $role = auth()->user()->role; // Assuming role is stored in a 'role' column in the users table
    
     
   
            return redirect()->route('reservation.index')->with('success', 'Reservation cancelled successfully.');
    
    }

    public function cancel_reservation_for_user(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reason_for_cancel' => 'required|string|max:255', // Validation rule for the cancellation reason
        ]);
    
        $reservation->update([
            'is_cancelled' => true,
            'is_approved' => false,
            'is_successful' => false,
            'reason_for_cancel' => $request->input('reason_for_cancel'), // Store the reason for cancellation
        ]);
    
        $driver = $reservation->driver;
        $car = $reservation->car;
    
        if ($driver) {
            $driver->update(['driver_status' => 'available']);
        }
        if ($car) {
            $car->update(['car_status' => 'available']);
        }
   
        return redirect()->route('reservation.my_reservations')->with('success', 'Reservation cancelled successfully.');

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

    //checked
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

           

    //checked
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


    //checked
    public function show_history()
    {
        // Retrieve the ID of the authenticated user
        $userId = Auth::id();
    
        // Retrieve the reservations associated with the authenticated user's ID
        $reservations = Reservation::where('user_id', $userId)
            ->where('is_successful', true)
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
    
    //checked
    public function search(Request $request)
    {
        // Retrieve the selected quarter from the request
        $quarter = $request->quarter;
    
        // Determine the start and end dates of the selected quarter
        $startDate = null;
        $endDate = null;
    
        switch ($quarter) {
            case 'Q1':
                $startDate = '2024-01-01';
                $endDate = '2024-03-31';
                break;
            case 'Q2':
                $startDate = '2024-04-01';
                $endDate = '2024-06-30';
                break;
            case 'Q3':
                $startDate = '2024-07-01';
                $endDate = '2024-09-30';
                break;
            case 'Q4':
                $startDate = '2024-10-01';
                $endDate = '2024-12-31';
                break;
            default:
                // Default to current quarter if invalid quarter provided
                $startDate = now()->startOfQuarter()->toDateString();
                $endDate = now()->endOfQuarter()->toDateString();
                break;
        }
    
        $reservations = Reservation::with('driver', 'user')
        ->where('is_successful', true)
        ->whereBetween('date_of_travel', [$startDate, $endDate])
        ->when($request->user_name, function ($query) use ($request) {
            $query->whereHas('user', function ($subquery) use ($request) {
                $subquery->where('name', 'like', '%' . $request->user_name . '%');
            });
        })
        ->paginate(10);
    
    
        // Fetch the list of cars and corresponding reservation counts for the selected quarter
        $cars = Reservation::where('is_successful', true)
            ->whereBetween('date_of_travel', [$startDate, $endDate])
            ->join('cars', 'reservations.car_id', '=', 'cars.id')
            ->select('cars.plate_number')
            ->distinct()
            ->get()
            ->pluck('plate_number');
    
        $reservationsCount = [];
        foreach ($cars as $plate_number) {
            $count = Reservation::where('is_successful', true)
                ->join('cars', 'reservations.car_id', '=', 'cars.id')
                ->where('cars.plate_number', $plate_number)
                ->whereBetween('date_of_travel', [$startDate, $endDate])
                ->count();
            $reservationsCount[] = $count;
        }
    
        return view('administrator.completed_reservation', compact('reservations', 'cars', 'reservationsCount'));
    }
    
    public function travelStatusUpdate(Request $request, Reservation $reservation)
    {
        // Validate only the fields you want to update
        $validatedData = $request->validate([
            'travel_status' => 'required|string|max:50',
        ]);

        $reservation->update($validatedData);
        return redirect()->route('reservation.approved')->with('success', 'Travel Status Updated!');
    }

    public function exportCompletedTravels(Request $request)
{
    // Retrieve the selected quarter from the request
    $quarter = $request->quarter;
    
    // Determine the start and end dates of the selected quarter
    $startDate = null;
    $endDate = null;

    switch ($quarter) {
        case 'Q1':
            $startDate = '2024-01-01';
            $endDate = '2024-03-31';
            break;
        case 'Q2':
            $startDate = '2024-04-01';
            $endDate = '2024-06-30';
            break;
        case 'Q3':
            $startDate = '2024-07-01';
            $endDate = '2024-09-30';
            break;
        case 'Q4':
            $startDate = '2024-10-01';
            $endDate = '2024-12-31';
            break;
        default:
            // Default to current quarter if invalid quarter provided
            $startDate = now()->startOfQuarter()->toDateString();
            $endDate = now()->endOfQuarter()->toDateString();
            break;
    }

    $reservations = Reservation::with('driver', 'user')
    ->where('is_successful', true)
    ->whereBetween('date_of_travel', [$startDate, $endDate])
    ->when($request->user_name, function ($query) use ($request) {
        $query->whereHas('user', function ($subquery) use ($request) {
            $subquery->where('name', 'like', '%' . $request->user_name . '%');
        });
    })
    ->paginate(10);


    // Fetch the list of cars and corresponding reservation counts for the selected quarter
    $cars = Reservation::where('is_successful', true)
        ->whereBetween('date_of_travel', [$startDate, $endDate])
        ->join('cars', 'reservations.car_id', '=', 'cars.id')
        ->select('cars.plate_number')
        ->distinct()
        ->get()
        ->pluck('plate_number');

    $reservationsCount = [];
    foreach ($cars as $plate_number) {
        $count = Reservation::where('is_successful', true)
            ->join('cars', 'reservations.car_id', '=', 'cars.id')
            ->where('cars.plate_number', $plate_number)
            ->whereBetween('date_of_travel', [$startDate, $endDate])
            ->count();
        $reservationsCount[] = $count;
    }


     // Load the PDF layout view
     $pdfView = view('administrator.completed_travels_pdf', compact('reservations'))->render();

     // Setup dompdf options
     $options = new Options();
     $options->set('isHtml5ParserEnabled', true);
     $options->set('isRemoteEnabled', true);
 
     // Instantiate Dompdf with options
     $dompdf = new Dompdf($options);
     $dompdf->loadHtml($pdfView);
 
     // (Optional) Set paper size and orientation
     $dompdf->setPaper('A4', 'landscape');
 
     // Render the HTML as PDF
     $dompdf->render();
 
   
    $leftLogoPath = public_path('home/images/bsulogo.png');
    $rightLogoPath = public_path('home/images/elugan.png');
   
    $imageWidth = 100; 
    $imageHeight = 100;// Adjust according to the actual height of your image


    $pageWidth = 840; 

    // Calculate the coordinates for the top-right corner
    $leftLogoX = 10; // Adjust the X coordinate if needed
    $leftLogoY = 10; // Adjust the Y coordinate if needed

    $rightLogoX = $pageWidth - $imageWidth - 10; // Adjust the margin if needed
    $rightLogoY = 10; // Adjust the Y coordinate if needed

    // Add the images to the PDF
    $dompdf->getCanvas()->image($leftLogoPath, $leftLogoX, $leftLogoY-10, $imageWidth, $imageHeight);
    $dompdf->getCanvas()->image($rightLogoPath, $rightLogoX, $rightLogoY, $imageWidth-20, $imageHeight-20);

     return $dompdf->stream('completed_reservations.pdf');

}
    
    public function show_user_cancelled()
    {
        $user = auth()->user(); // Get the currently authenticated user
        
        // Fetch only the cancelled reservations of the current user
        $reservations = $user->reservations()->where('is_cancelled', true)
            ->latest()
            ->paginate(10);

        // Format dates
        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }

        // Pass the reservations to the view
        return view('user.user_cancelled_travels', compact('reservations'));
    }


}
