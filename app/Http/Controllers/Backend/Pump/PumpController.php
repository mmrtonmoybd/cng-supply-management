<?php

namespace App\Http\Controllers\Backend\Pump;

use App\Http\Controllers\Controller;
use App\Models\Pump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PumpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Pump::class);
        return view('backend.pump.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pump $pump)
    {
        Gate::authorize('viewAny', $pump);
        return view('backend.pump.show', compact('pump'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pump $pump)
    {
        Gate::authorize('update', $pump);

        return view('backend.pump.edit', compact('pump'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pump $pump)
    {
        Gate::authorize('update', $pump);

        $request->validate([
            'payment_date' => 'nullable|date',
            'payment' => 'nullable|numeric|min:0',
            'balance' => 'nullable|numeric|min:0',
            'vehicle_reg_number' => 'required|string|max:255',
            'pump_name' => 'nullable|required|string|max:255',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'purchase_taka' => 'required|numeric|min:0',
            'fuel_cost' => 'nullable|numeric|min:0',
            'fuel_pump' => 'nullable|string|max:255',
            'factory_name' => 'nullable|string|max:255',
            'status' => 'nullable|required|boolean',
            'remark' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
            'diesel_litter' => 'nullable|numeric|min:0',
            'diesel_rate' => 'nullable|numeric|min:0',
        ]);

        $onlyrequest = $request->only([
            'payment_date',
            'payment',
            'balance',
        ]);

        $marge = array_merge([
            'remarks' => $request->input('premarks'),
        ], $onlyrequest);

        $pump->update($marge);

        $onlyreq = $request->only([
            'vehicle_reg_number',
            'pump_name',
            'cng_purchase_m3',
            'rate',
            'purchase_taka',
            'fuel_cost',
            'fuel_pump',
            'factory_name',
            'status',
            'remark',
            'diesel_litter',
            'diesel_rate',
        ]);

        $pump->loada()->update($onlyreq);

        return redirect()->route('backend.pump.index')->with('growl', ['The data has been correctly updated.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pump $pump)
    {
        //
    }
}
