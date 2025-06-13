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
        $this->authorize('diesel_crud');
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
        $this->authorize('diesel_crud');

        return view('backend.diesel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('diesel_crud');
        $validated = $request->validate([
            'd_date' => 'nullable|date',
            'd_time' => 'nullable',
            'slip_no' => 'nullable|string',
            'pumpName_id' => 'nullable|exists:pump_names,id',
            'vehicle_reg_number' => 'required',
            'diesel_purchase_litre' => 'nullable|numeric',
            'taka' => 'nullable|numeric',
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
        $this->authorize('diesel_crud');

        return view('backend.diesel.show', compact('diesel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diesel $diesel)
    {
        $this->authorize('diesel_crud');

        return view('backend.diesel.edit', compact('diesel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diesel $diesel)
    {
        $this->authorize('diesel_crud');
        $validated = $request->validate([
            'd_date' => 'nullable|date',
            'd_time' => 'nullable',
            'slip_no' => 'nullable|string',
            'pumpName_id' => 'nullable|exists:pump_names,id',
            'vehicle_reg_number' => 'required',
            'diesel_purchase_litre' => 'nullable|numeric',
            'taka' => 'nullable|numeric',
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
        $this->authorize('diesel_crud');

        return response()->json(['success' => $diesel->delete() ?? false]);
    }

    /**
     * Show the filter form and results.
     */
    public function filter(Request $request)
    {
        $this->authorize('diesel_crud');
        $diesels = collect([]); // Empty collection by default

        // Only query if filter button was clicked
        if ($request->has('filter')) {
            $query = Diesel::query()
                ->with(['pumpname'])
                ->select('*');

            // Apply date range filter
            if ($request->filled(['from_date', 'to_date'])) {
                $query->whereBetween('d_date', [
                    $request->input('from_date'),
                    $request->input('to_date'),
                ]);
            } else {
                // Default to current month if no date range selected
                $query->whereMonth('d_date', now()->month)
                    ->whereYear('d_date', now()->year);
            }

            // Apply pump filter
            if ($request->filled('pumpName_id')) {
                $query->where('pumpName_id', $request->input('pumpName_id'));
            }

            // Apply vehicle filter
            if ($request->filled('car_no')) {
                $query->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
            }

            $diesels = $query->orderBy('d_date', 'ASC')->get();

            $dbtotaldiesel = $query->count('id');
            $dbtotaldiesel_purchase_litre = $query->sum('diesel_purchase_litre');
            $dbtotaltaka = $query->sum('taka');
            $dbtotaldistance = $query->sum('distance');
            $dbtotaluse_litre = $query->sum('use_litre');
            $dbtotaluse_balance = $query->sum('use_balance');

            return view('backend.diesel.filter', compact('diesels', 'dbtotaldiesel', 'dbtotaldiesel_purchase_litre', 'dbtotaltaka', 'dbtotaldistance', 'dbtotaluse_litre', 'dbtotaluse_balance'));
        }

        return view('backend.diesel.filter', compact('diesels'));
    }
}
