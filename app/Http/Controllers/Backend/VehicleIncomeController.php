<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Diesel;
use App\Models\VehicleIncome;
use Illuminate\Http\Request;

class VehicleIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('vehicle_income_crud');

        return view('backend.vehicleincome.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('vehicle_income_crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('vehicle_income_crud');
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleIncome $vehicleincome)
    {
        $this->authorize('vehicle_income_crud');

        return view('backend.vehicleincome.show', compact('vehicleincome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleIncome $vehicleincome)
    {
        $this->authorize('vehicle_income_crud');

        return view('backend.vehicleincome.edit', compact('vehicleincome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleIncome $vehicleincome)
    {
        $this->authorize('vehicle_income_crud');
        $request->validate([
            'rent' => 'nullable|numeric',
            'driver_fooding' => 'nullable|numeric',
            'maintenance' => 'nullable|numeric',
            'other' => 'nullable|numeric',
        ]);

        $vehicleincome->update($request->all());

        return redirect()->route('backend.vehicleIncome.index')->with('growl', [
            'The data has been correctly updated.',
            'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleIncome $vehicleIncome)
    {
        $this->authorize('vehicle_income_crud');
    }

    public function filter()
    {
        $this->authorize('vehicle_income_crud');

        return view('backend.vehicleincome.filter');
    }

    public function showFilter(Request $request)
    {
        $this->authorize('vehicle_income_crud');
        $query = VehicleIncome::with(['pumpname', 'factory']);
        $diesel = Diesel::query();
        if ($request->filled('pumpName_id')) {
            $query->where('pumpName_id', $request->pumpName_id);
            $diesel->where('pumpName_id', $request->pumpName_id);
        }
        if ($request->filled('factory_id')) {
            $query->where('factory_id', $request->factory_id);
            $diesel->where('factory_id', $request->factory_id);
        }
        if ($request->filled('car_no')) {
            $query->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
            $diesel->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
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
        $results = $query->orderBy('date', 'ASC')->get();
        $dbtotal = $query->count('id');
        $dbtotalcng_purchase_m3 = $query->sum('cng_purchase_m3');
        $dbtotalpurchase_taka = $query->sum('purchase_taka');
        $dbtotalfm3 = $query->sum('fm3');
        $dbtotalftk = $query->sum('ftk');
        $dbtotaldifference = $query->sum('difference');
        $dieselsum = $diesel->sum('taka');
        $dbtotalnet_difference = $dbtotaldifference - $dieselsum;
        $dbtotalrent = $query->sum('rent');
        $dbtotaldriver_fooding = $query->sum('driver_fooding');
        $dbtotalmaintenance = $query->sum('maintenance');
        $dbtotalother = $query->sum('other');
        $totalcost = $dbtotalrent + $dbtotaldriver_fooding + $dbtotalmaintenance + $dbtotalother;
        $net_profit = $dbtotalnet_difference - $totalcost;

        return view('backend.vehicleincome.filter', compact('results', 'dbtotal', 'dbtotalcng_purchase_m3', 'dbtotalpurchase_taka',
            'dbtotalfm3', 'dbtotalftk', 'dbtotaldifference', 'dieselsum', 'dbtotalnet_difference', 'dbtotalrent', 'dbtotaldriver_fooding',
            'dbtotalmaintenance', 'dbtotalother', 'totalcost', 'net_profit'));
    }

    public function showFilterPrint(Request $request)
    {
        $this->authorize('vehicle_income_crud');
        $query = VehicleIncome::with(['pumpname', 'factory']);
        $diesel = Diesel::query();
        if ($request->filled('pumpName_id')) {
            $query->where('pumpName_id', $request->pumpName_id);
            $diesel->where('pumpName_id', $request->pumpName_id);
        }
        if ($request->filled('factory_id')) {
            $query->where('factory_id', $request->factory_id);
            $diesel->where('factory_id', $request->factory_id);
        }
        if ($request->filled('car_no')) {
            $query->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
            $diesel->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
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

        // Clone for totals
        $clone = clone $query;

        // SQL group-by summary like transport
        $results = $query->selectRaw('
            vehicle_reg_number,
            SUM(cng_purchase_m3) as cng_purchase_m3,
            SUM(purchase_taka) as purchase_taka,
            SUM(fm3) as fm3,
            SUM(ftk) as ftk,
            SUM(difference) as difference,
            SUM(rent) as rent,
            SUM(driver_fooding) as driver_fooding,
            SUM(maintenance) as maintenance,
            SUM(other) as other,
            COUNT(*) as trip_count
        ')
            ->groupBy('vehicle_reg_number')
            ->orderBy('vehicle_reg_number')
            ->get();

        // Totals
        $dbtotal = $clone->count();
        $dbtotalcng_purchase_m3 = $clone->sum('cng_purchase_m3');
        $dbtotalpurchase_taka = $clone->sum('purchase_taka');
        $dbtotalfm3 = $clone->sum('fm3');
        $dbtotalftk = $clone->sum('ftk');
        $dbtotaldifference = $clone->sum('difference');
        $dieselsum = $diesel->sum('taka');
        $dbtotalnet_difference = $dbtotaldifference - $dieselsum;
        $dbtotalrent = $clone->sum('rent');
        $dbtotaldriver_fooding = $clone->sum('driver_fooding');
        $dbtotalmaintenance = $clone->sum('maintenance');
        $dbtotalother = $clone->sum('other');
        $totalcost = $dbtotalrent + $dbtotaldriver_fooding + $dbtotalmaintenance + $dbtotalother;
        $net_profit = $dbtotalnet_difference - $totalcost;

        return view('backend.vehicleincome.printcopy', compact(
            'results',
            'dbtotal',
            'dbtotalcng_purchase_m3',
            'dbtotalpurchase_taka',
            'dbtotalfm3',
            'dbtotalftk',
            'dbtotaldifference',
            'dieselsum',
            'dbtotalnet_difference',
            'dbtotalrent',
            'dbtotaldriver_fooding',
            'dbtotalmaintenance',
            'dbtotalother',
            'totalcost',
            'net_profit'
        ));
    }
}
