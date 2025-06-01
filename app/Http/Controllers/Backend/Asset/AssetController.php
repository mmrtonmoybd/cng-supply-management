<?php

namespace App\Http\Controllers\Backend\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.assets.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $typeText = $request->input('type_text');
        $finalType = $typeText ?: $type;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);
        $validated['type'] = strtolower($finalType);
        Asset::create($validated);
        return redirect()->route('backend.asset.asset.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        $asset->load('vehicle');
        return view('backend.assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        // Get all unique types for the select
        $typeOptions = Asset::distinct()->pluck('type')->filter()->unique()->values()->toArray();
        return view('backend.assets.edit', compact('asset', 'typeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $type = $request->input('type');
        $typeText = $request->input('type_text');
        $finalType = $typeText ?: $type;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);
        $validated['type'] = strtolower($finalType);
        $asset->update($validated);
        return redirect()->route('backend.asset.asset.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        return response()->json(['success' => $asset->delete() ?? false]);
    }
}
