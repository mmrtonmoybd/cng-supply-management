@extends('boilerplate::layout.index', [
    'title' => 'Cng Pump Slip',
    'subtitle' => 'Edit Cng Pump Slip',
])

@section('content')
<x-boilerplate::form :route="['backend.factory.cngpump.update', $cngPump->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.cngpump.index') }}" class="btn btn-default" data-toggle="tooltip" title="Cng Pump Slip lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
<x-boilerplate::card>
    <div class="row">
        <div class="col-md-4">
            @php
                $loadOptions = \App\Models\LoadEntry::where('status', 0)
                    ->orWhere('id', $cngPump->load_entry_id)
                    ->orderByDesc('id')->get();
            @endphp
            <div class="form-group">
                <label for="load_entry_id">Load ID</label>
                <select name="load_entry_id" id="load_entry_id" class="form-control select2">
                    <option value="">No Load select</option>
                    @foreach($loadOptions as $load)
                        <option value="{{ $load->id }}" {{ (string)old('load_entry_id', $cngPump->load_entry_id) === (string)$load->id ? 'selected' : '' }}>
                            Car no: {{ $load->vehicle_reg_number }}, Pump name: {{ $load->pump_name }} & Date: {{ $load->date }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no', $cngPump->bill_no)" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date', $cngPump->bill_date)" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="in" label="In" type="number" step="0.01" :value="old('in', $cngPump->in)" placeholder="In" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="out" label="Out" type="number" step="0.01" :value="old('out', $cngPump->out)" placeholder="Out" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="fm3" label="FM3" type="number" step="0.01" :value="old('fm3', $cngPump->fm3)" placeholder="FM3" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.01" :value="old('rate', $cngPump->rate)" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="ftk" label="FTK" type="number" step="0.01" :value="old('ftk', $cngPump->ftk)" placeholder="FTK" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date', $cngPump->cash_receipt_date)" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.01" :value="old('cash_receipt_amount', $cngPump->cash_receipt_amount)" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" type="text" :value="old('recived_by', $cngPump->recived_by)" placeholder="Received By" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="remarks" label="Remarks" type="text" :value="old('remarks', $cngPump->remarks)" placeholder="Remarks" />
        </div>
        <h2 class="col-md-12 mt-4"><font color="red">Manual third party input(This input field will be use if no Load ID is selected, otherwise ignore.)</font></h2>
        <div class="col-md-4">
            <x-boilerplate::input name="date" label="Date" type="date" :value="old('date', $cngPump->date)" placeholder="Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="vehicle_reg_number" label="Car No" :value="old('vehicle_reg_number', $cngPump->vehicle_reg_number)" placeholder="Car No" />
        </div>
        <div class="col-md-4">
            @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedPump = old('pumpName_id', $cngPump->pumpName_id);
            @endphp
            <label for="pumpName_id">Pump Name</label>
            <select name="pumpName_id" id="pumpName_id" class="form-control " required>
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if ($selectedPump == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cng_purchase_m3" label="M3" type="number" step="0.01" :value="old('cng_purchase_m3', $cngPump->cng_purchase_m3)" placeholder="M3" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="lrate" label="Rate" type="number" step="0.01" :value="old('lrate', $cngPump->lrate)" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="purchase_taka" label="Purchase Taka" type="number" step="0.01" :value="old('purchase_taka', $cngPump->purchase_taka)" placeholder="Purchase Taka" />
        </div>
        <div class="col-md-4">

            @php
                $factoryOptions = \App\Models\Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedFactory = old('factory_id', $cngPump->factory_id);
            @endphp
            <label for="factory_id">Factory Name</label>
            <select name="factory_id" id="factory_id" class="form-control " >
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if ($selectedFactory == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
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
    // M3 * lrate = purchase_taka logic
    if (!isNaN(m3) && !isNaN(lrate) && purchaseTakaInput && purchaseTakaInput.value === '') {
        purchaseTakaInput.value = (m3 * lrate).toFixed(2);
    } else if (!isNaN(lrate) && !isNaN(purchaseTakaInput.value) && (isNaN(m3) || document.querySelector('[name="cng_purchase_m3"]').value === '')) {
        var calculatedM3 = parseFloat(purchaseTakaInput.value) / lrate;
        if (!isNaN(calculatedM3)) {
            document.querySelector('[name="cng_purchase_m3"]').value = calculatedM3.toFixed(2);
        }
    }

}

$(function() {
    $('form').on('submit', function(e) {
        calculateFM3FTKOnSubmit(e);
    });
});
</script>
@endpush
