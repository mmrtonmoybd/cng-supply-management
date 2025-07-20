<?php

namespace App\Http\Controllers\Backend\Invoice;

use App\Http\Controllers\Controller;
use App\Models\CngPump;
use App\Models\Dispansar;
use App\Models\Invoice;
use App\Models\Weight;
use App\Models\WeightOne;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('invoice_crud');

        return view('backend.factory.invoice.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('invoice_crud');

        return view('backend.factory.invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('invoice_crud');
        $request->validate([
            'factory' => 'required',
            'factories_id' => 'required',
            'date' => 'required|date',
            'invoice_number' => 'required|string|max:255',
        ]);

        if ($request->factory == 'dispansar') {
            $model = Dispansar::whereIn('id', $request->factories_id)->whereNull('invoice_id');
            $total = $model->sum('bill_amount');
            $factory = $model->first()->factory_id;

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            Dispansar::whereIn('id', $request->factories_id)->whereNull('invoice_id')->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Dispenser invoice created successfully.', 'success']);

        } elseif ($request->factory == 'weightone') {

            $model = WeightOne::whereIn('id', $request->factories_id)->whereNull('invoice_id');
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            WeightOne::whereIn('id', $request->factories_id)->whereNull('invoice_id')->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Cng Pump & Weight Scale invoice created successfully.', 'success']);

        } elseif ($request->factory == 'cngpump') {

            $model = CngPump::whereIn('id', $request->factories_id)->whereNull('invoice_id');
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            CngPump::whereIn('id', $request->factories_id)->whereNull('invoice_id')->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Weight scale invoice created successfully.', 'success']);

        } elseif ($request->factory == 'weight') {

            $model = Weight::whereIn('id', $request->factories_id)->whereNull('invoice_id');
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            Weight::whereIn('id', $request->factories_id)->whereNull('invoice_id')->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['CNG Pump Slip invoice created successfully.', 'success']);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $this->authorize('invoice_crud');

        return view('backend.factory.invoice.show', compact('invoice'));
    }

    public function export(Invoice $invoice, Request $request)
    {
        $this->authorize('invoice_crud');

        if ($request->filled('header')) {
            return view('backend.factory.invoice.invoice2', compact('invoice'));
        }

        return view('backend.factory.invoice.invoice', compact('invoice'));
    }

    public function verify($hash)
    {
        $invoice = Invoice::where('hash', $hash)->firstOrFail();

        return view('backend.factory.invoice.invoice', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('invoice_crud');

        return view('backend.factory.invoice.edit', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('invoice_crud');
        $request->validate([
            'factory' => 'required',
            'factories_id' => 'required',
            'date' => 'required|date',
            'invoice_number' => 'required|string|max:255',
        ]);

        if ($request->factory == 'dispansar') {
            $model = Dispansar::whereIn('id', $request->factories_id);
            $total = $model->sum('bill_amount');
            $factory = $model->first()->factory_id;

            Dispansar::where('invoice_id', $invoice->id)->update(['invoice_id' => null, 'invoice_date' => null]);

            $invoice->update([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            Dispansar::whereIn('id', $request->factories_id)->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Dispenser invoice updated successfully.', 'success']);

        } elseif ($request->factory == 'weightone') {

            $model = WeightOne::whereIn('id', $request->factories_id);
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            WeightOne::where('invoice_id', $invoice->id)->update(['invoice_id' => null, 'invoice_date' => null]);

            $invoice->update([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            WeightOne::whereIn('id', $request->factories_id)->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Cng Pump & Weight Scale invoice updated successfully.', 'success']);

        } elseif ($request->factory == 'cngpump') {

            $model = Weight::whereIn('id', $request->factories_id);
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            Weight::where('invoice_id', $invoice->id)->update(['invoice_id' => null, 'invoice_date' => null]);

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            Weight::whereIn('id', $request->factories_id)->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['Weight scale invoice updated successfully.', 'success']);

        } elseif ($request->factory == 'weight') {

            $model = CngPump::whereIn('id', $request->factories_id);
            $total = $model->sum('ftk');
            $factory = $model->first()->factory_id;

            CngPump::where('invoice_id', $invoice->id)->update(['invoice_id' => null, 'invoice_date' => null]);

            $invoice = Invoice::create([
                'date' => $request->input('date'),
                'factory_type' => $request->input('factory'),
                'total' => $total,
                'factory_id' => $factory,
                'invoice_number' => $request->input('invoice_number'),
            ]);

            CngPump::whereIn('id', $request->factories_id)->update(['invoice_id' => $invoice->id, 'invoice_date' => $request->date]);

            return redirect()->route('backend.factory.invoice.show', $invoice->id)
                ->with('growl', ['CNG Pump Slip invoice updated successfully.', 'success']);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('invoice_crud');

        return response()->json(['success' => $invoice->delete() ?? false]);
    }
}
