@extends('boilerplate::layout.index', [
    'title' => 'Dispenser',
    'subtitle' => 'Create Dispenser',
    'breadcrumb' => [
        'Dispenser' => 'backend.factory.dispansar.index',
        'Create' => 'backend.factory.dispansar.create',
    ]
])

@section('content')
@php
    $loadOptions = \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();
@endphp
<x-boilerplate::form route="backend.factory.dispansar.store">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.dispansar.index') }}" class="btn btn-default" data-toggle="tooltip" title="Dispenser lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
<x-boilerplate::card>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="load_entry_id">Load ID</label>
                <select name="load_entry_id" id="load_entry_id" class="form-control select2">
                    <option value="">No Load select</option>
                    @foreach($loadOptions as $load)
                        <option value="{{ $load->id }}" {{ old('load_entry_id') == $load->id ? 'selected' : '' }}>
                            Car no: {{ $load->vehicle_reg_number }}, Pump name: {{ $load->pump_name }} & Date: {{ $load->date }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no', 0)" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date')" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="opening_reading" label="Opening Reading" type="number" step="0.01" :value="old('opening_reading', 0)" placeholder="Opening Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="closing_reading" label="Closing Reading" type="number" step="0.01" :value="old('closing_reading', 0)" placeholder="Closing Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.01" :value="old('rate', 0)" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="in" label="In" type="number" step="0.01" :value="old('in', 0)" placeholder="In" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="out" label="Out" type="number" step="0.01" :value="old('out', 0)" placeholder="Out" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date')" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.01" :value="old('cash_receipt_amount', 0)" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" :value="old('recived_by')" placeholder="Received By" />
        </div>
        <div class="col-md-12">
            <x-boilerplate::input name="remarks" label="Remarks" :value="old('remarks')" placeholder="Remarks" />
        </div>
        <h2 class="col-md-12 mt-4"><font color="red">Manual third party input(This input field will be use if no Load ID is selected, otherwise ignore.)</font></h2>
        
        <div class="col-md-4">
            <x-boilerplate::input name="date" label="Date" type="date" :value="old('date')" placeholder="Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="vehicle_reg_number" label="Car No" :value="old('vehicle_reg_number')" placeholder="Car No" />
        </div>
        <div class="col-md-4">
            @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <label for="pumpName_id">Pump Name</label>
            <select name="pumpName_id"  class="form-control">
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('pumpName_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cng_purchase_m3" label="M3" type="number" step="0.01" :value="old('cng_purchase_m3')" placeholder="M3" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="lrate" label="Rate" type="number" step="0.01" :value="old('lrate')" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="purchase_taka" label="Purchase Taka" type="number" step="0.01" :value="old('purchase_taka')" placeholder="Purchase Taka" />
        </div>
        <div class="col-md-4">
            @php
                $factoryOptions = \App\Models\Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <label for="factory_id">Factory Name</label>
            <select name="factory_id"  class="form-control">
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('factory_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
