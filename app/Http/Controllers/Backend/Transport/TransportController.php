<?php

namespace App\Http\Controllers\Backend\Transport;

use App\Http\Controllers\Controller;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.transport.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.transport.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'rent' => 'nullable|numeric',
            'maintenance_cost' => 'nullable|numeric',
            'diesel_cost' => 'nullable|numeric',
            'toll_cost' => 'nullable|numeric',
            'labour_cost' => 'nullable|numeric',
            'chada_cost' => 'nullable|numeric',
            'fooding_cost' => 'nullable|numeric',
            'police_cost' => 'nullable|numeric',
            'parking_cost' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
        ]);

        Transport::create($validated);

        return redirect()->route('backend.transport.index')
            ->with('growl', ['The data created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transport $transport)
    {
        return view('backend.transport.show', compact('transport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transport $transport)
    {
        return view('backend.transport.edit', compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transport $transport)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'rent' => 'nullable|numeric',
            'maintenance_cost' => 'nullable|numeric',
            'diesel_cost' => 'nullable|numeric',
            'toll_cost' => 'nullable|numeric',
            'labour_cost' => 'nullable|numeric',
            'chada_cost' => 'nullable|numeric',
            'fooding_cost' => 'nullable|numeric',
            'police_cost' => 'nullable|numeric',
            'parking_cost' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
        ]);

        $transport->update($validated);

        return redirect()->route('backend.transport.index')
            ->with('growl', ['The data has been correctly updated.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        return response()->json(['success' => $transport->delete() ?? false]);
    }

    /**
     * Export the specified resource as a printable view.
     */
    public function export(Transport $transport)
    {
        return view('backend.transport.export', compact('transport'));
    }

    /**
     * Show the filter form and results.
     */
    public function filter()
    {
        return view('backend.transport.filter');
    }

    /**
     * Display the filtered results.
     */
    public function showFilter(Request $request)
    {
        $query = Transport::with(['vehicle'])
            ->select('*');

        // Apply vehicle filter
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereBetween('date', [
                    $dates[0],
                    $dates[1],
                ]);
            }
        }

        $transports = $query->orderBy('date', 'ASC')->get();

        // Calculate totals
        $totals = [
            'rent' => $transports->sum('rent'),
            'maintenance_cost' => $transports->sum('maintenance_cost'),
            'diesel_cost' => $transports->sum('diesel_cost'),
            'toll_cost' => $transports->sum('toll_cost'),
            'labour_cost' => $transports->sum('labour_cost'),
            'chada_cost' => $transports->sum('chada_cost'),
            'fooding_cost' => $transports->sum('fooding_cost'),
            'police_cost' => $transports->sum('police_cost'),
            'parking_cost' => $transports->sum('parking_cost'),
            'other_cost' => $transports->sum('other_cost'),
        ];

        $totals['total_cost'] = $totals['maintenance_cost'] + $totals['diesel_cost'] + $totals['toll_cost'] +
                              $totals['labour_cost'] + $totals['chada_cost'] + $totals['fooding_cost'] +
                              $totals['police_cost'] + $totals['parking_cost'] + $totals['other_cost'];

        $totals['net_income'] = $totals['rent'] - $totals['total_cost'];

        return view('backend.transport.filter', compact('transports', 'totals'));
    }
}
