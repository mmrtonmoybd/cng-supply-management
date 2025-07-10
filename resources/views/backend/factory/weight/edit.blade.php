@extends('boilerplate::layout.index', [
    'title' => 'Weight Scale',
    'subtitle' => 'Edit Weight Scale',
])

@section('content')
<x-boilerplate::form :route="['backend.factory.weight.update', $weight->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.weight.index') }}" class="btn btn-default" data-toggle="tooltip" title="Weight Scale lists">
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
                $loadOptions = \App\Models\LoadEntry::with('pumpname', 'factory')->whereHas('factory', function($factoryQuery) {
    return $factoryQuery->where('type', 'Weight scale');
    })->where('status', 0)
                    ->orWhere('id', $weight->load_entry_id)
                    ->orderByDesc('id')->get();
            @endphp
            <div class="form-group">
                <label for="load_entry_id">Load ID</label>
                <select name="load_entry_id" id="load_entry_id" class="form-control select2">
                    <option value="">No Load select</option>
                    @foreach($loadOptions as $load)
                        <option value="{{ $load->id }}" {{ (string)old('load_entry_id', $weight->load_entry_id) === (string)$load->id ? 'selected' : '' }}>
                            {{ $load->vehicle_reg_number }}, {{ $load->pumpname->name }}, {{ $load->factory->name }} & {{ $load->date }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no', $weight->bill_no)" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date', $weight->bill_date)" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="first_weight" label="First Weight" type="number" step="0.001" :value="old('first_weight', $weight->first_weight)" placeholder="First Weight" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="second_weight" label="Second Weight" type="number" step="0.001" :value="old('second_weight', $weight->second_weight)" placeholder="Second Weight" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="fact" label="Fact" type="number" step="0.001" :value="old('fact', $weight->fact)" placeholder="Fact" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.001" :value="old('rate', $weight->rate)" placeholder="Rate" />
        </div>
        <div class="col-md-4" hidden>
            <x-boilerplate::input name="total_bill_no" label="Total Bill No" type="text" :value="old('total_bill_no', $weight->total_bill_no)" placeholder="Total Bill No" />
        </div>
        <div class="col-md-4" hidden>
            <x-boilerplate::input name="total_bill_taka" label="Total Bill Taka" type="text" :value="old('total_bill_taka', $weight->total_bill_taka)" placeholder="Total Bill Taka" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="in" label="In" type="number" step="0.001" :value="old('in', $weight->in)" placeholder="In" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="out" label="Out" type="number" step="0.001" :value="old('out', $weight->out)" placeholder="Out" />
        </div>
        <div class="col-md-4" hidden>
            <x-boilerplate::input name="bill_amount" label="Bill Amount" type="number" step="0.001" :value="old('bill_amount', $weight->bill_amount)" placeholder="Bill Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date', $weight->cash_receipt_date)" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.001" :value="old('cash_receipt_amount', $weight->cash_receipt_amount)" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" :value="old('recived_by', $weight->recived_by)" placeholder="Received By" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="remarks" label="Remarks" :value="old('remarks', $weight->remarks)" placeholder="Remarks" />
        </div>
        <div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
       যদি লোড আইডি সিলেক্ট করা থাকে সেক্ষেত্রে নিচের ফিল্ড গুলো পরিবর্তন করাতে উভয় জায়গায় টোটাল লোডের ডাটা গুলো পরিবর্তন হবে। যদি লোড আইডি সিলেক্ট করা না থাকে সেক্ষেত্রে নিচের ডাটা গুলো পরিবর্তন করায় থার্ড পার্টি ডাটা পরিবর্তন হবে।
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="date" label="Date" type="date" :value="old('date', $weight->date)" placeholder="Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="vehicle_reg_number" label="Car No" :value="old('vehicle_reg_number', $weight->vehicle_reg_number)" placeholder="Car No" />
        </div>
        <div class="col-md-4">
           @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedPump = old('pumpName_id', $weight->pumpName_id);
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
            @php
            $thirdparty = \App\Models\Pump::where('weight_id', $weight->id)->first()->third_party_pump_name ?? '';
            @endphp
            <x-boilerplate::input name="third_party_pump_name" label="Third party pump name" type="text" :value="old('third_party_pump_name', $thirdparty)" placeholder="Third party pump name" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cng_purchase_m3" label="M3" type="number" step="0.001" :value="old('cng_purchase_m3', $weight->cng_purchase_m3)" placeholder="M3" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="lrate" label="Rate" type="number" step="0.001" :value="old('lrate', $weight->lrate)" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="purchase_taka" label="Purchase Taka" type="number" step="0.001" :value="old('purchase_taka', $weight->purchase_taka)" placeholder="Purchase Taka" />
        </div>
        <div class="col-md-4">

            @php
                $factoryOptions = \App\Models\Factory::distinct()->where('type', 'Weight scale')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedFactory = old('factory_id', $weight->factory_id);
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
    var fm3 = parseFloat(document.querySelector('[name="fm3"]') ? document.querySelector('[name="fm3"]').value : '');
    var rate = parseFloat(document.querySelector('[name="rate"]') ? document.querySelector('[name="rate"]').value : '');
    var ftk = parseFloat(document.querySelector('[name="ftk"]') ? document.querySelector('[name="ftk"]').value : '');
    var fm3Input = document.querySelector('[name="fm3"]');
    var ftkInput = document.querySelector('[name="ftk"]');
    var m3 = parseFloat(document.querySelector('[name="cng_purchase_m3"]') ? document.querySelector('[name="cng_purchase_m3"]').value : '');
    var lrate = parseFloat(document.querySelector('[name="lrate"]') ? document.querySelector('[name="lrate"]').value : '');
    var purchaseTakaInput = document.querySelector('[name="purchase_taka"]');

    // FM3/FTK logic
    if (fm3Input && ftkInput) {
        if (!isNaN(fm3) && !isNaN(rate) && (isNaN(ftk) || ftkInput.value === '')) {
            var result = fm3 * rate;
            ftkInput.value = result.toFixed(2);
        } else if (!isNaN(ftk) && !isNaN(rate) && (isNaN(fm3) || fm3Input.value === '')) {
            if (rate !== 0) {
                var result = ftk / rate;
                fm3Input.value = result.toFixed(2);
            }
        }
    }
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

// Attach to form submit
$(function() {
    $('form').on('submit', function(e) {
        calculateFM3FTKOnSubmit(e);
    });
});
</script>
@endpush
