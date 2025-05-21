@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Edit Load',
])

@section('content')
<x-boilerplate::form :route="['backend.load.update', $loadEntry->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.load.index') }}" class="btn btn-default" data-toggle="tooltip" title="Load lists">
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
        <div class="col-6">
            <x-boilerplate::input name='date' label='Date' type='date' required :value="old('date', $loadEntry->date ?? '')" placeholder='Date'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='vehicle_reg_number' label='Car No' required :value="old('vehicle_reg_number', $loadEntry->vehicle_reg_number ?? '')" placeholder='Car No'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedPump = old('pumpName_id', $loadEntry->pumpName_id);
            @endphp
            <select name="pumpName_id" id="pumpName_id" class="form-control " required>
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if ($selectedPump == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='cng_purchase_m3' label='M3' type='number' step='0.01' :value="old('cng_purchase_m3', $loadEntry->cng_purchase_m3 ?? '')" placeholder='M3'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='rate' label='Rate' type='number' step='0.01' required :value="old('rate', $loadEntry->rate ?? '')" placeholder='Rate'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='purchase_taka' label='Purchase Taka' type='number' step='0.01' :value="old('purchase_taka', $loadEntry->purchase_taka ?? '')" placeholder='Purchase Taka'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">

            @php
                $factoryOptions = \App\Models\Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                $selectedFactory = old('factory_id', $loadEntry->factory_id);
            @endphp
            <select name="factory_id" id="factory_id" class="form-control " >
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if ($selectedFactory == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">

            <x-boilerplate::select2 name="status" label="Status" minimum-results-for-search="1" required>
                <option value="1" @if (old('status', $loadEntry->status) == '1') selected="selected" @endif>Use</option>
                <option value="0" @if (old('status', $loadEntry->status) == '0') selected="selected" @endif>Not use</option>
           </x-boilerplate::select2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-boilerplate::input name='remark' label='Remark' :value="old('remark', $loadEntry->remark ?? '')" placeholder='Remark'/>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>


$('form').on('submit', function(e) {
    // Only apply calculation if the user has changed the value in the form (not just loaded from DB)
    var m3Input = document.querySelector('[name="cng_purchase_m3"]');
    var rateInput = document.querySelector('[name="rate"]');
    var takaInput = document.querySelector('[name="purchase_taka"]');
    var m3 = parseFloat(m3Input ? m3Input.value : '');
    var rate = parseFloat(rateInput ? rateInput.value : '');
    var taka = parseFloat(takaInput ? takaInput.value : '');

    // Only auto-calculate if one of the fields is empty (user did not fill it)
    if ((m3Input.value === '' || m3Input.value === null) && takaInput.value !== '' && !isNaN(rate) && rate !== 0) {
        // If purchase_taka is filled but cng_purchase_m3 is empty, calculate cng_purchase_m3
        m3Input.value = (parseFloat(takaInput.value) / rate).toFixed(2);
    } else if ((takaInput.value === '' || takaInput.value === null) && m3Input.value !== '' && !isNaN(rate) && rate !== 0) {
        // If cng_purchase_m3 is filled but purchase_taka is empty, calculate purchase_taka
        takaInput.value = (parseFloat(m3Input.value) * rate).toFixed(2);
    }
    // If both are filled (from DB), do not modify
});
</script>
@endpush
