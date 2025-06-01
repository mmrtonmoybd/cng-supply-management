<?php

namespace App\Http\Controllers\Backend\Asset;

use App\Http\Controllers\Controller;
use App\Models\AssetDocument;
use Illuminate\Http\Request;

class AssetDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.assets.document.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.assets.document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'name' => 'required|string|max:255',
            'path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10000', // 10MB max
        ]);

        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath = $file->store('asset_documents', 'public');
            $validated['path'] = $filePath;
        }

        AssetDocument::create($validated);

        return redirect()->route('backend.asset.assetdocument.index')
            ->with('growl', ['Asset document created successfully.', 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetDocument $asset_document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetDocument $asset_document)
    {
        return view('backend.assets.document.edit', ['assetdocument' => $asset_document]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetDocument $asset_document)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'name' => 'required|string|max:255',
            'path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10000', // 10MB max
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath = $file->store('asset_documents', 'public');
            $validated['path'] = $filePath;
        } else {
            // If no new file, keep the old path
            unset($validated['path']);
        }

        $asset_document->update($validated);

        return redirect()->route('backend.asset.assetdocument.index')
            ->with('growl', ['Asset document updated successfully.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetDocument $asset_document)
    {
        //
    }
}
