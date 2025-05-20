<?php

namespace App\Http\Controllers\Backend\Load;

use App\Http\Controllers\Controller;
use App\Models\LoadEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LoadEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', LoadEntry::class);

        return view('backend.load.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', LoadEntry::class);

        return view('backend.load.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', LoadEntry::class);

        $validated = $request->validate([
            'date' => 'required|date',
            'vehicle_reg_number' => 'required|string|max:255',
            'cng_purchase_m3' => 'required|numeric',
            'rate' => 'required|numeric',
            'purchase_taka' => 'required|numeric',
            'factory_name' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'remark' => 'nullable|string',
            'pumpName_id' => 'nullable|required',
        ]);
        LoadEntry::create($validated);

        return redirect()->route('backend.load.index')->with('growl', [
            'The data has been correctly added.',
            'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LoadEntry $loadEntry)
    {
        Gate::authorize('view', $loadEntry);

        return view('backend.load.show', compact('loadEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoadEntry $loadEntry)
    {
        Gate::authorize('update', $loadEntry);

        return view('backend.load.edit', compact('loadEntry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoadEntry $loadEntry)
    {
        Gate::authorize('update', $loadEntry);

        $validated = $request->validate([
            'date' => 'required|date',
            'vehicle_reg_number' => 'required|string|max:255',
            'cng_purchase_m3' => 'required|numeric',
            'rate' => 'required|numeric',
            'purchase_taka' => 'required|numeric',
            'factory_name' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'remark' => 'nullable|string',
            'pumpName_id' => 'nullable|required',
        ]);
        $loadEntry->update($validated);

        return redirect()->route('backend.load.index')->with('growl', ['The data has been correctly updated.', 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoadEntry $loadEntry)
    {
        Gate::authorize('delete', $loadEntry);

        return response()->json(['success' => $loadEntry->delete() ?? false]);
    }

    /**
     * Show the filter form for LoadEntry
     */
    public function filter()
    {
        Gate::authorize('viewAny', LoadEntry::class);

        return view('backend.load.filter');
    }

    /**
     * Show filtered results for LoadEntry
     */
    public function showFilter(Request $request)
    {
        Gate::authorize('viewAny', LoadEntry::class);
        $query = LoadEntry::query();
        if ($request->filled('pumpName_id')) {
            $query->where('pumpName_id', $request->pumpName_id);
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
        if ($request->filled('status') && in_array($request->status, ['0', '1'])) {
            $query->where('status', $request->status);
        }
        $results = $query->orderBy('created_at', 'ASC')->get();

        return view('backend.load.filter', compact('results'));
    }
}
