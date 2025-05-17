<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\Dispansar;
use App\Models\LoadEntry;
use Illuminate\Http\Request;

class DispansarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.factory.dispansar.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.factory.dispansar.create');
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
            'opening_reading' => 'nullable|numeric',
            'closing_reading' => 'nullable|numeric',
            'rate' => 'numeric|required',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pump_name' => 'nullable|string|max:255',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
        ]);

        $data = [];

        if ($request->filled('load_entry_id')) {
            $load = LoadEntry::find($request->input('load_entry_id'));
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

        $data['total_reading'] = $request->input('closing_reading') - $request->input('opening_reading');
        $data['bill_amount'] = $request->input('rate') * $data['total_reading'];
        $data['difference_m3'] = $data['total_reading'] - $cng_purchase_m3;
        $data['difference_taka'] = $data['bill_amount'] - $purchase_taka;
        $data['balance'] = $request->input('cash_receipt_amount') - $data['bill_amount'];

        // Correctly merge $validated and $data
        $finalData = array_merge($validated, $data);

        // dd($finalData);

        Dispansar::create($finalData);

        if ($request->filled('load_entry_id')) {
            // $load = LoadEntry::find($request->input('load_entry_id'));
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.dispansar.index')
            ->with('growl', ['Factory Dispenser created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispansar $dispansar)
    {
        return view('backend.factory.dispansar.show', compact('dispansar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dispansar $dispansar)
    {
        return view('backend.factory.dispansar.edit', compact('dispansar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dispansar $dispansar)
    {
        $validated = $request->validate([
            'load_entry_id' => 'nullable|integer|exists:load_entries,id',
            'bill_no' => 'nullable|numeric',
            'bill_date' => 'nullable|date',
            'opening_reading' => 'nullable|numeric',
            'closing_reading' => 'nullable|numeric',
            'rate' => 'numeric|required',
            'in' => 'nullable|numeric',
            'out' => 'nullable|numeric',
            'cash_receipt_date' => 'nullable|date',
            'cash_receipt_amount' => 'nullable|numeric',
            'recived_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'vehicle_reg_number' => 'nullable|string|max:255',
            'pump_name' => 'nullable|string|max:255',
            'cng_purchase_m3' => 'nullable|numeric|min:0',
            'lrate' => 'nullable|numeric|min:0',
            'purchase_taka' => 'nullable|numeric|min:0',
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
            $data['load_entry_id'] = null;
        }

        $data['total_reading'] = $request->input('closing_reading') - $request->input('opening_reading');
        $data['bill_amount'] = $request->input('rate') * $data['total_reading'];
        $data['difference_m3'] = $data['total_reading'] - $cng_purchase_m3;
        $data['difference_taka'] = $data['bill_amount'] - $purchase_taka;
        $data['balance'] = $request->input('cash_receipt_amount') - $data['bill_amount'];
        $finalData = array_merge($validated, $data);

        if (! empty($dispansar->load_entry_id)) {
            $load = \App\Models\LoadEntry::find($dispansar->load_entry_id);
            $load->status = 0;
            $load->save();
        }

        $dispansar->update($finalData);

        if ($request->filled('load_entry_id')) {
            $load->date = $request->input('date');
            $load->vehicle_reg_number = $request->input('vehicle_reg_number');
            $load->pump_name = $request->input('pump_name');
            $load->cng_purchase_m3 = $request->input('cng_purchase_m3');
            $load->rate = $request->input('lrate');
            $load->purchase_taka = $request->input('purchase_taka');
            $load->status = 1;
            $load->save();
        }

        return redirect()->route('backend.factory.dispansar.index')
            ->with('growl', ['Factory Dispenser updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dispansar $dispansar)
    {
        $load = \App\Models\LoadEntry::find($dispansar->load_entry_id);
        $load->status = 0;
        $load->save();

        return response()->json(['success' => $dispansar->delete() ?? false]);
    }

    /**
     * AJAX for LoadEntry select2 in Dispenser create/edit
     */
    public function loadEntrySelect2(Request $request)
    {
        $search = $request->input('q');
        $query = \App\Models\LoadEntry::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_reg_number', 'like', "%$search%")
                    ->orWhere('pump_name', 'like', "%$search%")
                    ->orWhere('date', 'like', "%$search%")
                    ->orWhere('id', $search);
            });
        }
        $results = $query->orderByDesc('id')->limit(20)->get();
        $data = $results->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => 'Car no: '.$item->vehicle_reg_number.', Pump name: '.$item->pump_name.' & Date: '.$item->date,
            ];
        });

        return response()->json(['results' => $data]);
    }

    /**
     * Show the filter form for Dispenser
     */
    public function filter()
    {
        $pumpNames = \App\Models\LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name')->filter()->values();

        return view('backend.factory.dispansar.filter', compact('pumpNames'));
    }

    /**
     * Show filtered results for Dispenser
     */
    public function showFilter(Request $request)
    {
        $query = Dispansar::with('loada');
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
        $results = $query->orderBy('created_at', 'desc')->get();
        $pumpNames = \App\Models\LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name')->filter()->values();

        return view('backend.factory.dispansar.filter', compact('results', 'pumpNames'));
    }
}
