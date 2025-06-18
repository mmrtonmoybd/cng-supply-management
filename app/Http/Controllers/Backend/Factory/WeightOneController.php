<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\WeightOne;
use Illuminate\Http\Request;

class WeightOneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('weightone_crud');

        return view('backend.factory.weightone.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('weightone_crud');
        $loadOptions = \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();

        return view('backend.factory.weightone.create', compact('loadOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('weightone_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
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
        $ftk = is_numeric($request->input('ftk')) ? $request->input('ftk') : 0;
        $bill_amount = is_numeric($request->input('bill_amount')) ? $request->input('bill_amount') : 0;
        $cash_receipt_amount = is_numeric($request->input('cash_receipt_amount')) ? $request->input('cash_receipt_amount') : 0;
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;

        $total_weight = $first_weight - $second_weight;
        $data['total_weight'] = $total_weight;
        // $data['bill_amount'] = $request->input('rate') * $data['total_weight'];
        $data['difference_taka'] = $ftk - $purchase_taka;
        $data['balance'] = $cash_receipt_amount - $bill_amount;

        $finalData = array_merge($validated, $data);

        WeightOne::create($finalData);

        if ($request->filled('load_entry_id')) {
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.weightone.index')
            ->with('growl', ['Cng Pump & Weight Scale created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->authorize('weightone_crud');
        $weightone = WeightOne::findOrFail($id);

        return view('backend.factory.weightone.show', compact('weightone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeightOne $weightone)
    {
        $this->authorize('weightone_crud');
        $loadOptions = \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();

        return view('backend.factory.weightone.edit', [
            'weightone' => $weightone,
            'loadOptions' => $loadOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WeightOne $weightone)
    {
        $this->authorize('weightone_crud');
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'first_weight' => 'nullable|numeric',
            'second_weight' => 'nullable|numeric',
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
        $ftk = is_numeric($request->input('ftk')) ? $request->input('ftk') : 0;
        $bill_amount = is_numeric($request->input('bill_amount')) ? $request->input('bill_amount') : 0;
        $cash_receipt_amount = is_numeric($request->input('cash_receipt_amount')) ? $request->input('cash_receipt_amount') : 0;
        $cng_purchase_m3 = is_numeric($cng_purchase_m3) ? $cng_purchase_m3 : 0;
        $purchase_taka = is_numeric($purchase_taka) ? $purchase_taka : 0;

        $total_weight = $first_weight - $second_weight;
        $data['total_weight'] = $total_weight;
        // $data['bill_amount'] = $request->input('rate') * $data['total_weight'];
        $data['difference_taka'] = $ftk - $purchase_taka;
        $data['balance'] = $cash_receipt_amount - $bill_amount;

        $finalData = array_merge($validated, $data);

        // If previous load_entry_id exists, set its status back to 0
        if (! empty($weightone->load_entry_id)) {
            $oldLoad = \App\Models\LoadEntry::find($weightone->load_entry_id);
            if ($oldLoad) {
                $oldLoad->status = 0;
                $oldLoad->save();
            }
        }

        $weightone->update($finalData);

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

        return redirect()->route('backend.factory.weightone.index')
            ->with('growl', ['Cng Pump & Weight Scale updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeightOne $weightone)
    {
        $this->authorize('weightone_crud');

        // Find the related LoadEntry
        $load = \App\Models\LoadEntry::find($weightone->load_entry_id);

        // Only update if LoadEntry exists
        if ($load) {
            $load->status = 0;
            $load->save();
        }

        // Now delete the weight
        return response()->json(['success' => $weightone->delete() ?? false]);
    }

    /**
     * Show the filter form.
     */
    public function filter()
    {
        $this->authorize('weightone_crud');

        return view('backend.factory.weightone.filter');
    }

    /**
     * Display the filtered results.
     */
    public function showFilter(Request $request)
    {
        $this->authorize('weightone_crud');
        $query = WeightOne::with(['loada', 'pumpname', 'factory']);
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
        $dbtotal = $query->count('id');
        $dbtotalcng_purchase_m3 = $query->sum('cng_purchase_m3');
        $dbtotalpurchase_taka = $query->sum('purchase_taka');
        $dbtotalfm3 = $query->sum('fm3');
        $dbtotalftk = $query->sum('ftk');
        $dbtotaldifference_taka = $query->sum('difference_taka');
        $dbtotalcash_receipt_amount = $query->sum('cash_receipt_amount');

        return view('backend.factory.weightone.filter', compact('results', 'dbtotal', 'dbtotalcng_purchase_m3', 'dbtotalpurchase_taka', 'dbtotalfm3', 'dbtotalftk', 'dbtotaldifference_taka', 'dbtotalcash_receipt_amount'));
    }
}
