<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use Illuminate\Http\Request;

class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('factory_crud');

        return view('backend.factory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('factory_crud');

        return view('backend.factory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('factory_crud');
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        Factory::create($request->all());

        return redirect()->route('backend.factory.factory.index')->with('success', 'Factory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Factory $factory)
    {
        $this->authorize('factory_crud');

        return view('backend.factory.show', compact('factory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factory $factory)
    {
        $this->authorize('factory_crud');

        return view('backend.factory.edit', compact('factory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factory $factory)
    {
        $this->authorize('factory_crud');
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $factory->update($request->all());

        return redirect()->route('backend.factory.factory.index')->with('success', 'Factory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factory $factory)
    {
        $this->authorize('factory_crud');

        return response()->json(['success' => $factory->delete() ?? false]);
    }

    public function filter(Request $request)
    {
        $this->authorize('factory_crud');

        // Get unique pump names for the dropdown

        return view('backend.factory.filter');
    }

    public function filterResult(Request $request)
    {

        $this->authorize('factory_crud');

        $dates = explode(' - ', $request->date_range);
        $fromDate = date('Y-m-d', strtotime($dates[0]));
        $toDate = date('Y-m-d', strtotime($dates[1]));

        $query = Factory::with(['cngpump' => function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('date', [$fromDate, $toDate]);
        }, 'dispansar' => function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('date', [$fromDate, $toDate]);
        },
            'weight' => function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('date', [$fromDate, $toDate]);
            },
            'weightone' => function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('date', [$fromDate, $toDate]);
            }]);

        $results = $query->orderBy('name', 'ASC')->get()->map(function ($factory) {
            $cng_purchase_m3 = $factory->cngpump->sum('cng_purchase_m3') + $factory->dispansar->sum('cng_purchase_m3') + $factory->weight->sum('cng_purchase_m3') + $factory->weightone->sum('cng_purchase_m3');
            $purchase_taka = $factory->cngpump->sum('purchase_taka') + $factory->dispansar->sum('purchase_taka') + $factory->weight->sum('purchase_taka') + $factory->weightone->sum('purchase_taka');
            $cash_receipt_amount = $factory->cngpump->sum('cash_receipt_amount') + $factory->dispansar->sum('cash_receipt_amount') + $factory->weight->sum('cash_receipt_amount') + $factory->weightone->sum('cash_receipt_amount');
            $sell_m3 = $factory->cngpump->sum('fm3') + $factory->dispansar->sum('total_reading') + $factory->weight->sum('receive_m3') + $factory->weightone->sum('fm3');
            $sell_tk = $factory->cngpump->sum('ftk') + $factory->dispansar->sum('bill_amount') + $factory->weight->sum('ftk') + $factory->weightone->sum('ftk');

            $balance = $cash_receipt_amount - $sell_tk;
            $status = $balance > 0 ? 'Advance' : ($balance == 0 ? 'Paid' : 'Due');

            return [
                'id' => $factory->id,
                'name' => $factory->name,
                'cng_purchase_m3' => $cng_purchase_m3,
                'purchase_taka' => $purchase_taka,
                'cash_receipt_amount' => $cash_receipt_amount,
                'sell_m3' => $sell_m3,
                'sell_tk' => $sell_tk,
                'balance' => $balance,
                'status' => $status,
            ];
        });

        // dd($results);

        $dbtotalpump = $results->count();
        $dbtotal_m3 = $results->sum('cng_purchase_m3');
        $dbtotal_purchase_taka = $results->sum('purchase_taka');
        $dbtotal_cash_receipt_amount = $results->sum('cash_receipt_amount');
        $dbtotal_sell_m3 = $results->sum('sell_m3');
        $dbtotal_sell_tk = $results->sum('sell_tk');

        return view('backend.factory.filter', compact('results', 'dbtotal_m3', 'dbtotal_purchase_taka', 'dbtotalpump', 'dbtotal_cash_receipt_amount', 'dbtotal_sell_m3', 'dbtotal_sell_tk'));
    }
}
