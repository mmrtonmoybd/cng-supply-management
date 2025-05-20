<?php

namespace App\Http\Controllers\Backend\Factory;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use Illuminate\Http\Request;

class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factories = Factory::all();
        return view('backend.factory.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.factory.create');
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
        Factory::create($request->all());
        return redirect()->route('backend.factory.factory.index')->with('success', 'Factory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Factory $factory)
    {
        return view('backend.factory.show', compact('factory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factory $factory)
    {
        return view('backend.factory.edit', compact('factory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factory $factory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        
        $factory->update($request->all());
        return redirect()->route('backend.factory.factory.index')->with('success', 'Factory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factory $factory)
    {
        return response()->json(['success' => $factory->delete() ?? false]);
    }
}
