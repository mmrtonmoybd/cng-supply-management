<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.factory.weight.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loadOptions = \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();

        return view('backend.factory.weight.create', compact('loadOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pump_name' => 'nullable|string|max:255',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'rate' => 'numeric|required',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
            'fact' => 'nullable|numeric',
            'receive_m3' => 'nullable|numeric',
            'ftk' => 'nullable|numeric|min:0',
            'total_bill_no' => 'nullable|numeric',
            'total_bill_taka' => 'nullable|numeric|min:0',
            'difference_taka' => 'nullable|numeric|min:0',
            'difference_m3' => 'nullable|numeric|min:0',
        ]);

        $data = [];

        if ($request->filled('load_entry_id')) {
            $load = \App\Models\LoadEntry::find($request->input('load_entry_id'));
            $cng_purchase_m3 = $load->cng_purchase_m3;
            $purchase_taka = $load->purchase_taka;

            $data['date'] = $load->date;
            $data['vehicle_reg_number'] = $load->vehicle_reg_number;
            $data['pump_name'] = $load->pump_name;
            $data['lrate'] = $load->rate;
            $data['cng_purchase_m3'] = $load->cng_purchase_m3;
            $data['purchase_taka'] = $load->purchase_taka;
        } else {
            $cng_purchase_m3 = $request->input('cng_purchase_m3');
            $purchase_taka = $request->input('purchase_taka');

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pump_name'] = $request->input('pump_name');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        }

        $data['total_weight'] = $request->input('first_weight') - $request->input('second_weight');
        $data['receive_m3'] = $data['total_weight'] * $request->input('fact');
        $data['ftk'] = $data['receive_m3'] * $request->input('rate');
        $data['difference_m3'] = $data['receive_m3'] - $cng_purchase_m3;
        $data['difference_taka'] = $data['ftk'] - $purchase_taka;

        $finalData = array_merge($validated, $data);

        Weight::create($finalData);

        if ($request->filled('load_entry_id')) {
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.weight.index')
            ->with('growl', ['Weight Scale created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        return view('backend.factory.weight.show', compact('weight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weight $weight)
    {
        return view('backend.factory.weight.edit', compact('weight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weight $weight)
    {
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pump_name' => 'nullable|string|max:255',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'rate' => 'numeric|required',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
            'fact' => 'nullable|numeric',
            'receive_m3' => 'nullable|numeric',
            'ftk' => 'nullable|numeric|min:0',
            'total_bill_no' => 'nullable|numeric',
            'total_bill_taka' => 'nullable|numeric|min:0',
            'difference_taka' => 'nullable|numeric|min:0',
            'difference_m3' => 'nullable|numeric|min:0',
            'bill_amount' => 'nullable|numeric|min:0',
        ]);

        $data = [];

        if ($request->filled('load_entry_id')) {
            $load = \App\Models\LoadEntry::find($request->input('load_entry_id'));
            $cng_purchase_m3 = $load->cng_purchase_m3;
            $purchase_taka = $load->purchase_taka;

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pump_name'] = $request->input('pump_name');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        } else {
            $cng_purchase_m3 = $request->input('cng_purchase_m3');
            $purchase_taka = $request->input('purchase_taka');

            $data['date'] = $request->input('date');
            $data['vehicle_reg_number'] = $request->input('vehicle_reg_number');
            $data['pump_name'] = $request->input('pump_name');
            $data['lrate'] = $request->input('lrate');
            $data['cng_purchase_m3'] = $request->input('cng_purchase_m3');
            $data['purchase_taka'] = $request->input('purchase_taka');
        }

        $data['total_weight'] = $request->input('first_weight') - $request->input('second_weight');
        $data['receive_m3'] = $data['total_weight'] * $request->input('fact');
        $data['ftk'] = $data['receive_m3'] * $request->input('rate');
        $data['difference_m3'] = $data['receive_m3'] - $cng_purchase_m3;
        $data['difference_taka'] = $data['ftk'] - $purchase_taka;

        $finalData = array_merge($validated, $data);

        // If previous load_entry_id exists, set its status back to 0
        if (! empty($weight->load_entry_id)) {
            $oldLoad = \App\Models\LoadEntry::find($weight->load_entry_id);
            if ($oldLoad) {
                $oldLoad->status = 0;
                $oldLoad->save();
            }
        }

        $weight->update($finalData);

        if ($request->filled('load_entry_id')) {
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.weight.index')
            ->with('growl', ['Weight Scale updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        $load = \App\Models\LoadEntry::find($weight->load_entry_id);
        $load->status = 0;
        $load->save();

        return response()->json(['success' => $weight->delete() ?? false]);
    }

    public function filter()
    {
        $pumpNames = \App\Models\LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name')->filter()->values();

        return view('backend.factory.weight.filter', compact('pumpNames'));
    }

    /**
     * Display the filtered results.
     */
    public function showFilter(Request $request)
    {
        $query = Weight::query();
        if ($request->filled('pump_name')) {
            $query->where('pump_name', $request->pump_name);
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
        $pumpNames = \App\Models\LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name')->filter()->values();

        return view('backend.factory.weight.filter', compact('results', 'pumpNames'));
    }
}
