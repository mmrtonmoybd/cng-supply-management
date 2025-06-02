<?php

namespace App\Http\Controllers\Backend\Diesel;

use App\Http\Controllers\Controller;
use App\Models\Diesel;
use Illuminate\Http\Request;
use Rawilk\Settings\Facades\Settings;

class DieselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->filled('factor_liter') || $request->filled('factor_balance')) {
            $request->validate([
                'factor_liter' => 'required|numeric',
                'factor_balance' => 'required|numeric',
            ]);
            // Update settings with the provided values
            Settings::set('factor_liter', $request->input('factor_liter'));
            $factor_liter = $request->input('factor_liter');
            Settings::set('factor_liter', $factor_liter);
            $factor_balance = $request->input('factor_balance');
            Settings::set('factor_balance', $factor_balance);

            return redirect()->route('backend.diesel.index')->with('growl', ['Settings updated successfully.', 'success']);
        }

        return view('backend.diesel.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.diesel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'd_date' => 'required|date',
            'd_time' => 'required',
            'slip_no' => 'nullable|string',
            'pumpName_id' => 'required|exists:pump_names,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'diesel_purchase_litre' => 'required|numeric',
            'taka' => 'required|numeric',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'distance' => 'nullable|numeric',
            'remark' => 'nullable|string',
        ]);

        Diesel::create($validated);

        return redirect()->route('backend.diesel.index')->with('growl', ['Diesel created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Diesel $diesel)
    {
        return view('backend.diesel.show', compact('diesel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diesel $diesel)
    {
        return view('backend.diesel.edit', compact('diesel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diesel $diesel)
    {
        $validated = $request->validate([
            'd_date' => 'required|date',
            'd_time' => 'required',
            'slip_no' => 'nullable|string',
            'pumpName_id' => 'required|exists:pump_names,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'diesel_purchase_litre' => 'required|numeric',
            'taka' => 'required|numeric',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'distance' => 'nullable|numeric',
            'remark' => 'nullable|string',
        ]);

        $diesel->update($validated);

        return redirect()->route('backend.diesel.index')
            ->with('growl', ['Diesel updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diesel $diesel)
    {
        return response()->json(['success' => $diesel->delete() ?? false]);
    }
}
