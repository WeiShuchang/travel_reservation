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

class ReservationController extends Controller
{

    // Display a listing of the reservations.
    public function index()
    {
        $reservations = Reservation::where('is_approved', false)
            ->where('is_successful', false)
            ->where('is_cancelled', false)
            ->latest()
            ->get();
    
        return view('administrator.user_reservations', compact('reservations'));
    }    

    // Show the form for creating a new reservation.
    public function create()
    {
        return view('user.reservation');
    }

    // Store a newly created reservation in storage.
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'requestor_name' => 'required|string|max:255',
                'office_department_college' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'appointment_status' => 'required|string|max:255',
                'requestor_address' => 'nullable|string|max:255',
                'number_of_passengers' => 'required|integer|min:1',
                'destination' => 'required|string|max:255',
                'date_of_travel' => 'required|date',
                'purpose_of_travel' => 'required|string|max:255',
            ]);

            $validatedData['user_id'] = Auth::id();

            // Create the reservation
            Reservation::create($validatedData);

            return redirect()->route('user')->with('success', 'Reservation created successfully.');
        } catch (ValidationException $e) {
            // Redirect back with validation error messages
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Failed to create reservation. Please try again.');
        }
    }

    // Display the specified reservation.
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
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
        // Validate the request data
        $validatedData = $request->validate([
            'requestor_name' => 'required|string|max:255',
            'office_department_college' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'appointment_status' => 'required|string|max:255',
            'requestor_address' => 'nullable|string|max:255',
            'number_of_passengers' => 'required|integer|min:1',
            'destination' => 'required|string|max:255',
            'date_of_travel' => 'required|date',
            'purpose_of_travel' => 'required|string|max:255',
            'expected_return_date' => 'required|date',
            'driver_id' => 'required|exists:drivers,id',
            'car_id' => 'required|exists:cars,id',
        ]);
    
        // Update the reservation
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
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('administrator.approved_reservations', compact('reservations'));
    }

    public function show_cancelled(Reservation $reservation){
        $reservations = Reservation::where('is_cancelled', true)
            ->latest()
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('administrator.cancelled_reservation', compact('reservations'));
        
    }

    public function show_completed(Reservation $reservation){
        $reservations = Reservation::where('is_successful', true)
            ->latest()
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->date_of_travel = Carbon::parse($reservation->date_of_travel)->format('F d, Y');
            $reservation->expected_return_date = Carbon::parse($reservation->expected_return_date)->format('F d, Y');
        }
    
        return view('administrator.completed_reservation', compact('reservations'));
        
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
        ->get();

        // Pass the reservations data to the view
        return view('user.my_reservations', ['reservations' => $reservations]);
    }
    
}
