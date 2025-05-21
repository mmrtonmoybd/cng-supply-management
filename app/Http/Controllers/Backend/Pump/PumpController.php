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
            'vehicle_reg_number' => 'required|string|max:255',
            'pumpName_id' => 'nullable|required',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'purchase_taka' => 'required|numeric|min:0',
            'factory_id' => 'nullable',
            'status' => 'nullable|required|boolean',
            'remark' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $onlyrequest = $request->only([
            'payment_date',
            'payment',
        ]);

        $balance = $pump->loada->purchase_taka - $request->input('payment');

        $marge = array_merge([
            'balance' => $balance,
            'remarks' => $request->input('premarks'),
        ], $onlyrequest);

        $pump->update($marge);

        $onlyreq = $request->only([
            'vehicle_reg_number',
            'pumpName_id',
            'cng_purchase_m3',
            'rate',
            'purchase_taka',
            'factory_id',
            'status',
            'remark',
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

    /**
     * Show the filter form
     */
    public function filter()
    {
        Gate::authorize('viewAny', Pump::class);

        // Get unique pump names for the dropdown

        return view('backend.pump.filter');
    }

    /**
     * Show filtered results
     */
    public function showFilter(Request $request)
    {
        Gate::authorize('viewAny', Pump::class);

        $query = Pump::with('loada');

        // Filter by pump name if provided
        if ($request->filled('pumpName_id')) {
            $query->whereHas('loada', function ($q) use ($request) {
                $q->where('pumpName_id', $request->pumpName_id);
            });
        }

        // Filter by car number if provided
        if ($request->filled('car_no')) {
            $query->whereHas('loada', function ($q) use ($request) {
                $q->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
            });
        }

        // Filter by date range if provided
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereHas('loada', function ($q) use ($dates) {
                    $q->whereBetween('date', [
                        date('Y-m-d', strtotime($dates[0])),
                        date('Y-m-d', strtotime($dates[1])),
                    ]);
                });
            }
        }

        $results = $query->orderBy('created_at', 'ASC')->get();

        return view('backend.pump.filter', compact('results'));
    }
}
