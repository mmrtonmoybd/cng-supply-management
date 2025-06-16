<?php

namespace App\Http\Controllers\Backend\Asset;

use App\Http\Controllers\Controller;
use App\Models\VehicleMaintenance;
use Illuminate\Http\Request;

class VehicleMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('vehicle_crud');

        return view('backend.assets.vehicle.maintenance.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('vehicle_crud');

        return view('backend.assets.vehicle.maintenance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('vehicle_crud');
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_cost' => 'required|numeric',
            'maintenance_date' => 'required|date',
        ]);

        VehicleMaintenance::create($request->all());

        return redirect()->route('backend.vehicle.vehiclemaintenance.index')
            ->with('growl', ['Vehicle maintenance created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleMaintenance $vehicle_maintenance)
    {
        $this->authorize('vehicle_crud');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleMaintenance $vehicle_maintenance)
    {
        $this->authorize('vehicle_crud');

        return view('backend.assets.vehicle.maintenance.edit', [
            'vehiclemaintenance' => $vehicle_maintenance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleMaintenance $vehicle_maintenance)
    {
        $this->authorize('vehicle_crud');
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_cost' => 'required|numeric',
            'maintenance_date' => 'required|date',
        ]);

        $vehicle_maintenance->update($request->all());

        return redirect()->route('backend.vehicle.vehiclemaintenance.index')
            ->with('growl', ['Vehicle maintenance updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleMaintenance $vehicle_maintenance)
    {
        $this->authorize('vehicle_crud');

        return response()->json(['success' => $vehicle_maintenance->delete() ?? false]);
    }
}
