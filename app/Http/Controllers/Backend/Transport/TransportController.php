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
}
