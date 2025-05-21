@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Load create',
])

@section('content')
<x-boilerplate::form route='backend.load.store'>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.load.index') }}" class="btn btn-default" data-toggle="tooltip" title="Load lists">
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
        <div class="col-6">
            <x-boilerplate::input name='date' label='Date' type='date' required :value="old('date')" placeholder='Date'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='vehicle_reg_number' label='Car No' required :value="old('vehicle_reg_number')" placeholder='Car No'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <select name="pumpName_id"  class="form-control" required>
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('pumpName_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='cng_purchase_m3' label='M3' type='number' step='0.01' :value="old('cng_purchase_m3')" placeholder='M3'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='rate' label='Rate' type='number' step='0.01' required :value="old('rate')" placeholder='Rate'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='purchase_taka' label='Purchase Taka' type='number' step='0.01' :value="old('purchase_taka')" placeholder='Purchase Taka'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @php
                $factoryOptions = \App\Models\Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <select name="factory_id"  class="form-control">
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('factory_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <x-boilerplate::select2 name="status" label="Status" minimum-results-for-search="1" required>
                <option value="1" @if (old('status', 1) == '1') selected="selected" @endif>Use</option>
                <option value="0" @if (old('status') == '0') selected="selected" @endif>Not use</option>
           </x-boilerplate::select2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-boilerplate::input name='remark' label='Remark' :value="old('remark')" placeholder='Remark'/>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection

@push('js')
<script>

$('form').on('submit', function(e) {
    var m3Input = document.querySelector('[name="cng_purchase_m3"]');
    var rateInput = document.querySelector('[name="rate"]');
    var takaInput = document.querySelector('[name="purchase_taka"]');
    var m3 = parseFloat(m3Input ? m3Input.value : '');
    var rate = parseFloat(rateInput ? rateInput.value : '');
    var taka = parseFloat(takaInput ? takaInput.value : '');

    if (!isNaN(m3) && m3 !== 0 && (isNaN(taka) || takaInput.value === '')) {
        if (!isNaN(rate) && rate !== 0) {
            takaInput.value = (m3 * rate).toFixed(2);
        }
    } else if (!isNaN(taka) && taka !== 0 && (isNaN(m3) || m3Input.value === '')) {
        if (!isNaN(rate) && rate !== 0) {
            m3Input.value = (taka / rate).toFixed(2);
        }
    }
});
</script>
@endpush