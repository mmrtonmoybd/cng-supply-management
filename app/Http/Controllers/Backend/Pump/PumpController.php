<?php

namespace App\Http\Controllers\Backend\Pump;

use App\Http\Controllers\Controller;
use App\Models\Diesel;
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
            'premarks' => 'nullable|string|max:1000',
            'new_rate' => 'nullable|numeric',
        ]);

        $onlyrequest = $request->only([
            'payment_date',
            'payment',
        ]);

       // $balance = $pump->loada->purchase_taka - $request->input('payment');

        $marge = array_merge([
            
            'remarks' => $request->input('premarks'),
            'new_rate' => $request->input('new_rate'),
        ], $onlyrequest);

        $pump->update($marge);

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

        $query = Pump::query();
        $diesel = Diesel::query();

        // Filter by pump name if provided
        if ($request->filled('pumpName_id')) {
            $query->where('pumpName_id', $request->pumpName_id);
            $diesel->where('pumpName_id', $request->pumpName_id);
        }
        if ($request->filled('car_no')) {
            $query->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
            $diesel->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
        }

        if ($request->filled('type')) {
            if ($request->input('type') == 1) {
                $query->whereHas('pumpname', function ($query) {
                    $query->where('type', 'Main');
                });
            } else {
                $query->whereHas('pumpname', function ($query) {
                    $query->where('type', 'Third Party');
                });
            }
        }

        if ($request->filled('diesel')) {
            if ($request->input('diesel') == 1) {
                $query->whereNotNull('diesel_id');
            } else {
                $query->whereNull('diesel_id');
            }
        } else {
            $query->whereNull('diesel_id');
        }

        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $diesel->whereBetween('d_date', [
                    date('Y-m-d', strtotime($dates[0])),
                    date('Y-m-d', strtotime($dates[1])),
                ]);
                $query->whereBetween('date', [
                    date('Y-m-d', strtotime($dates[0])),
                    date('Y-m-d', strtotime($dates[1])),
                ]);
            }
        }

        $dieselsum = $diesel->sum('taka');

        $results = $query->orderBy('created_at', 'ASC')->get();

        $dbtotalpump = $query->count('id');
        $dbtotal_m3 = $query->sum('cng_purchase_m3');
        $dbtotal_purchase_taka = $query->sum('purchase_taka');
        $dbtotal_payment = $query->sum('payment');

        return view('backend.pump.filter', compact('results', 'dieselsum', 'dbtotal_m3', 'dbtotal_purchase_taka', 'dbtotalpump', 'dbtotal_payment'));
    }
}
