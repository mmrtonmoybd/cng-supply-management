<?php

namespace App\Http\Controllers\Backend\Asset;

use App\Http\Controllers\Controller;
use App\Models\VehicleDocument;
use Illuminate\Http\Request;

class VehicleDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.assets.vehicle.document.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.assets.vehicle.document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10000', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath = $file->store('vehicle_documents', 'public');
            $validated['path'] = $filePath;
        }

        VehicleDocument::create($validated);

        return redirect()->route('backend.asset.vehicledocument.index')
            ->with('growl', ['Vehicle document created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleDocument $vehicle_document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleDocument $vehicle_document)
    {
        return view('backend.assets.vehicle.document.edit', ['vehicledocument' => $vehicle_document]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleDocument $vehicle_document)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10000', // 10MB max
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath = $file->store('vehicle_documents', 'public');
            $validated['path'] = $filePath;
        } else {
            // If no new file, keep the old path
            unset($validated['path']);
        }

        $vehicle_document->update($validated);

        return redirect()->route('backend.asset.vehicledocument.index')
            ->with('growl', ['Vehicle document updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleDocument $vehicle_document)
    {
        return response()->json(['success' => $vehicle_document->delete() ?? false]);
    }
}
