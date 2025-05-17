@extends('boilerplate::layout.index', [
    'title' => 'Weight One',
    'subtitle' => 'Create Weight One',
    'breadcrumb' => [
        'Weight One' => 'backend.factory.weightone.index',
        'Create' => 'backend.factory.weightone.create',
    ]
])

@section('content')
<x-boilerplate::form route="backend.factory.weightone.store">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.weightone.index') }}" class="btn btn-default" data-toggle="tooltip" title="Weight One lists">
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
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no')" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date')" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="first_weight" label="First Weight" type="number" step="0.01" :value="old('first_weight')" placeholder="First Weight" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="second_weight" label="Second Weight" type="number" step="0.01" :value="old('second_weight')" placeholder="Second Weight" />
        </div>
        
        <div class="col-md-4">
            <x-boilerplate::input name="fm3" label="FM3" type="number" step="0.01" :value="old('fm3')" placeholder="FM3" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.01" :value="old('rate')" placeholder="Rate" />
        </div>
        
        <div class="col-md-4">
            <x-boilerplate::input name="ftk" label="FTK" type="number" step="0.01" :value="old('ftk')" placeholder="FTK" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_amount" label="Bill Amount" type="number" step="0.01" :value="old('bill_amount')" placeholder="Bill Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date')" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.01" :value="old('cash_receipt_amount')" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" type="text" :value="old('recived_by')" placeholder="Received By" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="remarks" label="Remarks" type="text" :value="old('remarks')" placeholder="Remarks" />
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
                $pumpOptions = \App\Models\LoadEntry::distinct()->orderBy('pump_name', 'ASC')->pluck('pump_name', 'pump_name')->toArray();
            @endphp
            <select name="pump_name" id="pump_name" class="form-control select2-pump">
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('pump_name') == $key) selected @endif>{{ $value }}</option>
                @endforeach
                @if(old('pump_name') && !array_key_exists(old('pump_name'), $pumpOptions))
                    <option value="{{ old('pump_name') }}" selected>{{ old('pump_name') }}</option>
                @endif
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
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
@push('js')
<script>
$(document).ready(function() {
    $('#load_entry_id').select2({
        placeholder: 'Select Load',
        allowClear: true,
        width: '100%'
    });
});

function calculateFM3FTKOnSubmit(e) {
    var fm3 = parseFloat(document.querySelector('[name="fm3"]').value);
    var rate = parseFloat(document.querySelector('[name="rate"]').value);
    var ftk = parseFloat(document.querySelector('[name="ftk"]').value);
    var fm3Input = document.querySelector('[name="fm3"]');
    var ftkInput = document.querySelector('[name="ftk"]');
    var m3 = parseFloat(document.querySelector('[name="cng_purchase_m3"]').value);
    var lrate = parseFloat(document.querySelector('[name="lrate"]').value);
    var purchaseTakaInput = document.querySelector('[name="purchase_taka"]');

    // FM3/FTK logic
    if (!isNaN(fm3) && !isNaN(rate) && (isNaN(ftk) || ftkInput.value === '')) {
        var result = fm3 * rate;
        ftkInput.value = result.toFixed(2);
    } else if (!isNaN(ftk) && !isNaN(rate) && (isNaN(fm3) || fm3Input.value === '')) {
        if (rate !== 0) {
            var result = ftk / rate;
            fm3Input.value = result.toFixed(2);
        }
    }
    // M3 * lrate = purchase_taka logic
    if (!isNaN(m3) && !isNaN(lrate) && purchaseTakaInput) {
        purchaseTakaInput.value = (m3 * lrate).toFixed(2);
    }
}

// Attach to form submit
$(function() {
    $('form').on('submit', function(e) {
        calculateFM3FTKOnSubmit(e);
    });
});
</script>
@endpush

@php
    $loadOptions = $loadOptions ?? \App\Models\LoadEntry::where('status', 0)->orderByDesc('id')->get();
@endphp
