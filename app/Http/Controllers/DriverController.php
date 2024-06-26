<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::paginate(5);
        return view('administrator.driver_inventory', compact('drivers'));
    }

    public function create(Driver $drivers)
    {   
        $drivers = Driver::all();
        return view('administrator.add_driver', compact('drivers'));
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'driver_name' => 'required|string|max:100',
            'license_number' => 'required|string|max:100',
            'contact_number' => 'required|numeric',
            'driver_status' => 'required|string|max:50',
            'driver_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming max file size is 2MB
        ]);
    
        try {
            // Check if a file was uploaded
            if ($request->hasFile('driver_picture')) {
                // Store the uploaded file
                $imagePath = $request->file('driver_picture')->store('public/drivers');
                // Get the filename from the stored path
                $imageName = basename($imagePath);
            } else {
                // Use a default image if no file was uploaded
                $imageName = 'default-driver.jpeg';
            }
    
            // Create a new Driver instance
            $driver = new Driver();
            $driver->driver_name = $validatedData['driver_name'];
            $driver->license_number = $validatedData['license_number'];
            $driver->contact_number = $validatedData['contact_number'];
            $driver->driver_status = $validatedData['driver_status'];
            $driver->driver_picture = $imageName;
            
            // Save the driver
            $driver->save();
    
            // Redirect with success message
            return redirect()->route('drivers_inventory.index')->with('success', 'Driver successfully added');
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to add driver. Please try again.');
        }
    }
    

    public function edit($driver_id)
    {
        $driver = Driver::findOrFail($driver_id);
        return view('administrator.edit_driver', compact('driver'));
    }

    public function update(Request $request, $driver_id)
    {
        // Find the driver by its ID
        $driver = Driver::findOrFail($driver_id);
    
        // Validate the form data
        $validatedData = $request->validate([
            'driver_name' => 'required|string|max:100',
            'license_number' => 'required|string|max:100',
            'contact_number' => 'required|numeric',
            'driver_status' => 'required|string|max:50',
            'driver_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
        ]);
    
        // Update the driver object with the new data
        $driver->update([
            'driver_name' => $validatedData['driver_name'],
            'license_number' => $validatedData['license_number'],
            'contact_number' => $validatedData['contact_number'],
            'driver_status' => $validatedData['driver_status'],
        ]);
    
        // Handle driver picture update
        if ($request->hasFile('driver_picture')) {
            // Delete previous driver picture file if exists
            Storage::delete('public/drivers/' . $driver->driver_picture);
            
            // Store the new driver picture file
            $imageName = $request->file('driver_picture')->store('public/drivers');
            $driver->driver_picture = basename($imageName);
            $driver->save();
        }
    
        // Redirect with success message
        return redirect()->route('drivers_inventory.index')->with('success', 'Driver information edited successfully.');
    }
    

    public function destroy($driver_id)
    {
        try {
            $driver = Driver::findOrFail($driver_id);
            $driver->delete();
            return Redirect::route('drivers_inventory.index')->with('success', 'Driver successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if the exception is due to foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                return Redirect::back()->with('error', 'Cannot delete driver because they are associated with an existing reservations.');
            } else {
                // Handle other database errors
                return Redirect::back()->with('error', 'Failed to delete driver. Please try again later.');
            }
        }
    }
    
}
