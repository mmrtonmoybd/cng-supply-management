<?php

namespace App\Http\Controllers\Backend\Pump;

use App\Http\Controllers\Controller;
use App\Models\PumpName;
use Illuminate\Http\Request;

class PumpNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.pumpname.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pumpname.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        PumpName::create($request->all());
        return redirect()->route('backend.pumpname.index')->with('success', 'Pump Name created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PumpName $pumpname)
    {
        return view('backend.pumpname.show', compact('pumpname'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PumpName $pumpname)
    {
        return view('backend.pumpname.edit', compact('pumpname'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PumpName $pumpname)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        $pumpname->update($request->all());
        return redirect()->route('backend.pumpname.index')->with('success', 'Pump Name updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PumpName $pumpname)
    {
       return response()->json(['success' => $pumpname->delete() ?? false]);
    }
}
