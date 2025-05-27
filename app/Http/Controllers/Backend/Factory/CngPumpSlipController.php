<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\CngPump;
use Illuminate\Http\Request;

class CngPumpSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('cngpump_crud');

        return view('backend.factory.cngpump.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('cngpump_crud');

        return view('backend.factory.cngpump.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('cngpump_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'rate' => 'required|numeric',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pumpName_id' => 'nullable',
            'factory_id' => 'nullable',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'fm3' => 'nullable|numeric|min:0',
            'ftk' => 'nullable|numeric|min:0',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
        ]);

        $data = [];

        if ($request->filled('load_entry_id')) {
            $load = \App\Models\LoadEntry::find($request->input('load_entry_id'));
            $cng_purchase_m3 = $load->cng_purchase_m3;
            $purchase_taka = $load->purchase_taka;

            $data['date'] = $load->date;
            $data['vehicle_reg_number'] = $load->vehicle_reg_number;
            $data['pumpName_id'] = $load->pumpName_id;
            $data['factory_id'] = $load->factory_id;
            $data['lrate'] = $load->rate;
            $data['cng_purchase_m3'] = $load->cng_purchase_m3;
            $data['purchase_taka'] = $load->purchase_taka;
        } else {
            $cng_purchase_m3 = $request->input('cng_purchase_m3');
            $purchase_taka = $request->input('purchase_taka');

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pumpName_id'] = $request->input('pumpName_id');
            $data['factory_id'] = $request->input('factory_id');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        }

        // Use 0 as default if input is null or not numeric for calculations
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;
        $ftk = is_numeric($request->input('ftk')) ? $request->input('ftk') : 0;
        $fm3 = is_numeric($request->input('fm3')) ? $request->input('fm3') : 0;
        $cash_receipt_amount = is_numeric($request->input('cash_receipt_amount')) ? $request->input('cash_receipt_amount') : 0;

        $data['difference_taka'] = $ftk - $purchase_taka;
        $data['difference_m3'] = $fm3 - $cng_purchase_m3;
        $data['balance'] = $cash_receipt_amount - $ftk;

        $finalData = array_merge($validated, $data);

        CngPump::create($finalData);

        if ($request->filled('load_entry_id')) {
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.cngpump.index')
            ->with('growl', ['Cng Pump Slip created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CngPump $cngPump)
    {
        $this->authorize('cngpump_crud');

        return view('backend.factory.cngpump.show', [
            'cngPump' => $cngPump,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CngPump $cngPump)
    {
        $this->authorize('cngpump_crud');

        return view('backend.factory.cngpump.edit', [
            'cngPump' => $cngPump,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CngPump $cngPump)
    {
        $this->authorize('cngpump_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'rate' => 'required|numeric',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pumpName_id' => 'nullable',
            'factory_id' => 'nullable',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'fm3' => 'nullable|numeric|min:0',
            'ftk' => 'nullable|numeric|min:0',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
        ]);

        $data = [];

        if ($request->filled('load_entry_id')) {
            $load = \App\Models\LoadEntry::find($request->input('load_entry_id'));
            $cng_purchase_m3 = $load->cng_purchase_m3;
            $purchase_taka = $load->purchase_taka;

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pumpName_id'] = $request->input('pumpName_id');
            $data['factory_id'] = $request->input('factory_id');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        } else {
            $cng_purchase_m3 = $request->input('cng_purchase_m3');
            $purchase_taka = $request->input('purchase_taka');

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pumpName_id'] = $request->input('pumpName_id');
            $data['factory_id'] = $request->input('factory_id');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        }

        // Use 0 as default if input is null or not numeric for calculations
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;
        $ftk = is_numeric($request->input('ftk')) ? $request->input('ftk') : 0;
        $fm3 = is_numeric($request->input('fm3')) ? $request->input('fm3') : 0;
        $cash_receipt_amount = is_numeric($request->input('cash_receipt_amount')) ? $request->input('cash_receipt_amount') : 0;

        $data['difference_taka'] = $ftk - $purchase_taka;
        $data['difference_m3'] = $fm3 - $cng_purchase_m3;
        $data['balance'] = $cash_receipt_amount - $ftk;

        $finalData = array_merge($validated, $data);

        if (! empty($cngPump->load_entry_id)) {
            $oldLoad = \App\Models\LoadEntry::find($cngPump->load_entry_id);
            if ($oldLoad) {
                $oldLoad->status = 0;
                $oldLoad->save();
            }
        }

        $cngPump->update($finalData);

        if ($request->filled('load_entry_id')) {
            $load->date = $request->input('date');
            $load->vehicle_reg_number = $request->input('vehicle_reg_number');
            $load->pumpName_id = $request->input('pumpName_id');
            $load->factory_id = $request->input('factory_id');
            $load->cng_purchase_m3 = $request->input('cng_purchase_m3');
            $load->rate = $request->input('lrate');
            $load->purchase_taka = $request->input('purchase_taka');
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.cngpump.index')
            ->with('growl', ['Cng Pump Slip updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CngPump $cngPump)
    {
        $this->authorize('cngpump_crud');
        if (! $cngPump->load_entry_id) {
            return response()->json(['success' => $cngPump->delete() ?? false]);
        }
        $load = \App\Models\LoadEntry::find($cngPump->load_entry_id);
        $load->status = 0;
        $load->save();

        return response()->json(['success' => $cngPump->delete() ?? false]);
    }

    public function filter()
    {
        $this->authorize('cngpump_crud');

        return view('backend.factory.cngpump.filter');
    }

    /**
     * Display the filtered results.
     */
    public function showFilter(Request $request)
    {
        $this->authorize('cngpump_crud');
        $query = CngPump::with(['loada', 'pumpname', 'factory']);
        if ($request->filled('pumpName_id')) {
            $query->where('pumpName_id', $request->pumpName_id);
        }
        if ($request->filled('factory_id')) {
            $query->where('factory_id', $request->factory_id);
        }
        if ($request->filled('car_no')) {
            $query->where('vehicle_reg_number', 'like', '%'.$request->car_no.'%');
        }
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereBetween('date', [
                    date('Y-m-d', strtotime($dates[0])),
                    date('Y-m-d', strtotime($dates[1])),
                ]);
            }
        }
        $results = $query->orderBy('created_at', 'ASC')->get();

        return view('backend.factory.cngpump.filter', compact('results'));
    }
}
