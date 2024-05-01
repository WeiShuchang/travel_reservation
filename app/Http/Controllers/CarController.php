<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::paginate(5);
        return view("administrator.car_inventory",compact("cars"));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administrator.add_car");
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'make' => 'required|string|max:100',
                'model' => 'required|string|max:100',
                'year' => 'required|integer|min:1900' ,
                'color' => 'required|string|max:50',
                'seat_capacity' => 'required|string|max:50',
                'plate_number' => 'required|string|max:20',
                'mileage' => 'required|min:0',
                'engine_size' => 'required|string|max:50',
                'transmission' => 'required|string|max:50',
                'fuel_type' => 'required|string|max:50',
                'car_status' => 'required|string|max:50',
                'car_picture' => 'image|mimes:jpeg,png,jpg,gif', // Assuming max file size is 2MB
            ]);
    
            // Check if a file was uploaded
            if ($request->hasFile('car_picture')) {
                // Store the uploaded file
                $imagePath = $request->file('car_picture')->store('public/cars');
                // Get the filename from the stored path
                $imageName = basename($imagePath);
            } else {
                // Use a default image if no file was uploaded
                $imageName = 'default-driver.jpeg';
            }
    
    
            // Create a new Car instance
            $car = new Car();
            $car->make = $validatedData['make'];
            $car->model = $validatedData['model'];
            $car->year = $validatedData['year'];
            $car->color = $validatedData['color'];
            $car->seat_capacity = $validatedData['seat_capacity'];
            $car->plate_number = $validatedData['plate_number'];
            $car->mileage = $validatedData['mileage'];
            $car->engine_size = $validatedData['engine_size'];
            $car->transmission = $validatedData['transmission'];
            $car->fuel_type = $validatedData['fuel_type'];
            $car->car_status = $validatedData['car_status'];
            $car->car_picture = $imageName;
            
            // Save the car
            $car->save();
    
            // Redirect with success message
            return redirect()->route('cars_inventory.index')->with('success', 'Car successfully added');
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to add car. Please try again.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($car_id)
    {
        $car = Car::findOrFail($car_id);
        return view('administrator.edit_car', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $car_id)
    {
        try {

            $car = Car::findOrFail($car_id);
            // Validate the request data
            $validatedData = $request->validate([
                'make' => 'required|string|max:100',
                'model' => 'required|string|max:100',
                'year' => 'required|integer|min:1900' ,
                'color' => 'required|string|max:50',
                'seat_capacity' => 'required|string|max:50',
                'plate_number' => 'required|string|max:20',
                'mileage' => 'required|min:0',
                'engine_size' => 'required|string|max:50',
                'transmission' => 'required|string|max:50',
                'fuel_type' => 'required|string|max:50',
                'car_status' => 'required|string|max:50',
                'car_picture' => 'image|mimes:jpeg,png,jpg,gif', // Assuming max file size is 2MB
            ]);
            
            // Update the driver object with the new data
            $car->update([
                'make' => $validatedData['make'],
                'model' => $validatedData['model'],
                'year' => $validatedData['year'],
                'color' => $validatedData['color'],
                'seat_capacity' => $validatedData['seat_capacity'],
                'plate_number' => $validatedData['plate_number'],
                'mileage' => $validatedData['mileage'],
                'engine_size' => $validatedData['engine_size'],
                'transmission' => $validatedData['transmission'],
                'fuel_type' => $validatedData['fuel_type'],
                'car_status' => $validatedData['car_status'],
            ]);

       

             // Handle driver picture update
            if ($request->hasFile('car_picture')) {
            // Delete previous driver picture file if exists
            Storage::delete('public/cars/' . $car->car_picture);
            
            // Store the new driver picture file
            $imageName = $request->file('car_picture')->store('public/cars');
            $car->car_picture = basename($imageName);
            $car->save();
            }

           
    
        // Redirect with success message
            return redirect()->route('cars_inventory.index')->with('success', 'Car successfully Edited');

        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to edit car. Please try again.');
        }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($car_id)
    {
        $car = Car::findOrFail($car_id);
        $car->delete();
        return Redirect::route('cars_inventory.index')->with('success', 'Car successfully deleted');
    }
}
