<?php

namespace App\Http\Controllers\Backend\Asset;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.assets.vehicle.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.assets.vehicle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'vehicle_number' => 'required|string|max:255',
            'vehicle_type' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'driver_phone' => 'nullable|string|max:15',
            'registration_date' => 'nullable|date',
            'maintenance_date' => 'nullable|date',
            'status' => 'required|in:0,1',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('backend.asset.vehicle.index')->with('growl', ['Vehicle created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('backend.assets.vehicle.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('backend.assets.vehicle.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'vehicle_number' => 'required|string|max:255',
            'vehicle_type' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'driver_phone' => 'nullable|string|max:15',
            'registration_date' => 'nullable|date',
            'status' => 'required|in:0,1',
            'maintenance_date' => 'nullable|date',	
        ]);

        $vehicle->update($request->all());

        return redirect()->route('backend.asset.vehicle.index')->with('growl', ['Vehicle updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        return response()->json(['success' => $vehicle->delete() ?? false]);
    }
}
