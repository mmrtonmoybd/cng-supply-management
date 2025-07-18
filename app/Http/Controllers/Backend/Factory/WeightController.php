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
        $this->authorize('weight_crud');

        return view('backend.factory.weight.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('weight_crud');
        $loadOptions = \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();

        return view('backend.factory.weight.create', compact('loadOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('weight_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pumpName_id' => 'nullable',
            'factory_id' => 'nullable',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'rate' => 'nullable|numeric',
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

        // Safe numeric defaults for calculations
        $first_weight = is_numeric($request->input('first_weight')) ? $request->input('first_weight') : 0;
        $second_weight = is_numeric($request->input('second_weight')) ? $request->input('second_weight') : 0;
        $fact = is_numeric($request->input('fact')) ? $request->input('fact') : 0;
        $rate = is_numeric($request->input('rate')) ? $request->input('rate') : 0;
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;

        $total_weight = $first_weight - $second_weight;
        $data['total_weight'] = $total_weight;
        $data['receive_m3'] = $total_weight * $fact;
        $data['ftk'] = $data['receive_m3'] * $rate;
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
        $this->authorize('weight_crud');

        return view('backend.factory.weight.show', compact('weight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weight $weight)
    {
        $this->authorize('weight_crud');

        return view('backend.factory.weight.edit', compact('weight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weight $weight)
    {
        $this->authorize('weight_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pumpName_id' => 'nullable',
            'factory_id' => 'nullable',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'rate' => 'nullable|numeric',
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

        // Safe numeric defaults for calculations
        $first_weight = is_numeric($request->input('first_weight')) ? $request->input('first_weight') : 0;
        $second_weight = is_numeric($request->input('second_weight')) ? $request->input('second_weight') : 0;
        $fact = is_numeric($request->input('fact')) ? $request->input('fact') : 0;
        $rate = is_numeric($request->input('rate')) ? $request->input('rate') : 0;
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;

        $total_weight = $first_weight - $second_weight;
        $data['total_weight'] = $total_weight;
        $data['receive_m3'] = $total_weight * $fact;
        $data['ftk'] = $data['receive_m3'] * $rate;
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

        return redirect()->route('backend.factory.weight.index')
            ->with('growl', ['Weight Scale updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        $this->authorize('weight_crud');

        // Find the related LoadEntry
        $load = \App\Models\LoadEntry::find($weight->load_entry_id);

        // Only update if LoadEntry exists
        if ($load) {
            $load->status = 0;
            $load->save();
        }

        // Now delete the weight
        return response()->json(['success' => $weight->delete() ?? false]);
    }

    public function filter()
    {
        $this->authorize('weight_crud');

        return view('backend.factory.weight.filter');
    }

    /**
     * Display the filtered results.
     */
    public function showFilter(Request $request)
    {
        $this->authorize('weight_crud');
        $query = Weight::with(['loada', 'pumpname', 'factory']);
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
        $results = $query->orderBy('date', 'ASC')->get();
        $dbtotal = $query->count('id');
        $dbtotalcng_purchase_m3 = $query->sum('cng_purchase_m3');
        $dbtotalpurchase_taka = $query->sum('purchase_taka');
        $dbtotalfirst_weight = $query->sum('first_weight');
        $dbtotalsecond_weight = $query->sum('second_weight');
        $dbtotaltotal_weight = $query->sum('total_weight');
        $dbtotalreceive_m3 = $query->sum('receive_m3');
        $dbtotalftk = $query->sum('ftk');
        $dbtotaldifference_m3 = $query->sum('difference_m3');
        $dbtotaldifference_taka = $query->sum('difference_taka');
        $dbtotalcash_receipt_amount = $query->sum('cash_receipt_amount');

        return view('backend.factory.weight.filter', compact('results', 'dbtotal', 'dbtotalcng_purchase_m3', 'dbtotalpurchase_taka', 'dbtotalfirst_weight', 'dbtotalsecond_weight',
            'dbtotaltotal_weight', 'dbtotalreceive_m3', 'dbtotaldifference_m3', 'dbtotalftk', 'dbtotaldifference_taka', 'dbtotalcash_receipt_amount'));
    }
}
