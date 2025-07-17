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
    $loadOptions = \App\Models\LoadEntry::with('pumpname', 'factory')->whereHas('factory', function($factoryQuery) {
    return $factoryQuery->where('type', 'Dispenser');
    })->where('status', 0)->orderByDesc('id')->get();
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
                            {{ $load->vehicle_reg_number }}, {{ $load->pumpname->name }}, {{ $load->factory->name }} & {{ $load->date }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no')" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date')" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="opening_reading" label="Opening Reading" type="number" step="0.01" :value="old('opening_reading')" placeholder="Opening Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="closing_reading" label="Closing Reading" type="number" step="0.01" :value="old('closing_reading')" placeholder="Closing Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.01" :value="old('rate')" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="in" label="In" type="number" step="0.01" :value="old('in')" placeholder="In" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="out" label="Out" type="number" step="0.01" :value="old('out')" placeholder="Out" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date')" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.01" :value="old('cash_receipt_amount')" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" :value="old('recived_by')" placeholder="Received By" />
        </div>
        <div class="col-md-12">
            <x-boilerplate::input name="remarks" label="Remarks" :value="old('remarks')" placeholder="Remarks" />
        </div>

        <div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
        থার্ড পার্টি ডাটা যুক্ত করার ক্ষেত্রে অবশ্যয় লোড আইডি আন-সিলেক্ট হতে হবে। যদি লোড আইডি সিলেক্ট করা হয় সেক্ষেত্রে নিচের ফিল্ড গুলো কোন কাজে আসবে না(সেক্ষেত্রে লোডের ডাটা গুলো টোটাল লোড থেকে আসবে)।
        </div>
        
        
        <div class="col-md-4">
            <x-boilerplate::input name="date" label="Date" type="date" :value="old('date')" placeholder="Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="vehicle_reg_number" label="Car No" :value="old('vehicle_reg_number')" placeholder="Car No" />
        </div>
        <div class="col-md-4">
            @php
                $pumpOptions = \App\Models\PumpName::distinct()->where('is_diesel', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
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
            <x-boilerplate::input name="third_party_pump_name" label="Third party pump name" type="text" :value="old('third_party_pump_name')" placeholder="Third party pump name" />
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
                $factoryOptions = \App\Models\Factory::distinct()->where('type', 'Dispenser')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
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
<script>
$(document).ready(function() {
    $('#load_entry_id').select2({
        placeholder: 'Select Load',
        allowClear: true,
        width: '100%'
    });
});

function calculatePurchaseTakaOnSubmit(e) {
    var m3 = parseFloat(document.querySelector('[name="cng_purchase_m3"]').value);
    var lrate = parseFloat(document.querySelector('[name="lrate"]').value);
    var purchaseTakaInput = document.querySelector('[name="purchase_taka"]');
    var purchaseTaka = parseFloat(purchaseTakaInput.value);
    var m3Input = document.querySelector('[name="cng_purchase_m3"]');

    // If m3 and lrate are filled, calculate purchase_taka
    if (!isNaN(m3) && !isNaN(lrate) && purchaseTakaInput) {
        purchaseTakaInput.value = (m3 * lrate).toFixed(2);
    }
    // If m3 is empty, but lrate and purchase_taka are filled, calculate m3
    else if ((isNaN(m3) || m3Input.value === "") && !isNaN(lrate) && !isNaN(purchaseTaka) && lrate !== 0 && m3Input) {
        m3Input.value = (purchaseTaka / lrate).toFixed(2);
    }
}

// Attach to form submit
$(function() {
    $('form').on('submit', function(e) {
        calculatePurchaseTakaOnSubmit(e);
    });
});
</script>
@endsection
