<?php

namespace App\Http\Controllers\Backend\Pump;

use App\Http\Controllers\Controller;
use App\Models\PumpName;
use Illuminate\Http\Request;
use App\Models\Diesel;
use App\Models\Pump;

class PumpNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('pump_name_crud');

        return view('backend.pumpname.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('pump_name_crud');

        return view('backend.pumpname.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('pump_name_crud');
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        PumpName::create($request->all());

        return redirect()->route('backend.pumpname.index')->with('growl', ['The data has been correctly created.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(PumpName $pumpname)
    {
        $this->authorize('pump_name_crud');

        return view('backend.pumpname.show', compact('pumpname'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PumpName $pumpname)
    {
        $this->authorize('pump_name_crud');

        return view('backend.pumpname.edit', compact('pumpname'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PumpName $pumpname)
    {
        $this->authorize('pump_name_crud');
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        $pumpname->update($request->all());

        return redirect()->route('backend.pumpname.index')->with('growl', ['The data has been correctly updated.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PumpName $pumpname)
    {
        $this->authorize('pump_name_crud');

        return response()->json(['success' => $pumpname->delete() ?? false]);
    }

    public function filter(Request $request) {
        $this->authorize('pump_name_crud');

        // Get unique pump names for the dropdown

        return view('backend.pumpname.filter');
    }

    public function filterResult(Request $request) {

        $dates = explode(' - ', $request->date_range);
        $fromDate = date('Y-m-d', strtotime($dates[0]));
        $toDate = date('Y-m-d', strtotime($dates[1]));

        $query = PumpName::with(['diesel' => function ($query) use ($fromDate, $toDate) {
        $query->whereBetween('d_date', [$fromDate, $toDate]);
    }, 'pump' => function ($query) use ($fromDate, $toDate) {
        $query->whereBetween('date', [$fromDate, $toDate]);
    }]);

        // Filter by pump name if provided
        if ($request->filled('type')) {
            if ($request->input('type') == 1) {
                $query->where('type', 'Main');
            } else {
                $query->where('type', 'Third Party');
            }
        }

        $results = $query->orderBy('name', 'ASC')->get()->map(function ($pump) {
        $cng_purchase_m3 = $pump->pump->sum('cng_purchase_m3');
        $purchase_taka = $pump->pump->sum('purchase_taka');
        $payment = $pump->pump->sum('payment');
        $diesel_purchase = $pump->diesel->sum('taka');
        $diesel_liter = $pump->diesel->sum('diesel_purchase_litre');
        
        $balance = $payment - ($purchase_taka + $diesel_purchase);
        $status = $balance > 0 ? 'Advance' : ($balance == 0 ? 'Paid' : 'Due');

        return [
            'id' => $pump->id,
            'diesel_liter' => $diesel_liter,
            'diesel_purchase' => $diesel_purchase,
            'cng_purchase_m3' => $cng_purchase_m3,
            'purchase_taka' => $purchase_taka,
            'payment' => $payment,
            'name' => $pump->name,
            'balance' => $balance,
            'status' => $status,
        ];
    });

    //dd($results);

    $dbtotalpump = $results->count();
    $dieselsum = $results->sum('diesel_purchase');
    $dbtotal_m3 = $results->sum('cng_purchase_m3');
    $dbtotal_purchase_taka = $results->sum('purchase_taka');
    $dbtotal_payment = $results->sum('payment');


        return view('backend.pumpname.filter', compact('results', 'dieselsum', 'dbtotal_m3', 'dbtotal_purchase_taka', 'dbtotalpump', 'dbtotal_payment'));
    }
}
