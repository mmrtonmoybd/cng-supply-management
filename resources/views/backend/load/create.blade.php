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
                <button type="submit" class="btn btn-danger">
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
            <x-boilerplate::input name='pump_name' label='Pump Name' required :value="old('pump_name')" placeholder='Pump Name'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='cng_purchase_m3' label='M3' type='number' step='0.01' required :value="old('cng_purchase_m3')" placeholder='M3'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='rate' label='Rate' type='number' step='0.01' required :value="old('rate')" placeholder='Rate'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='purchase_taka' label='Purchase Taka' type='number' step='0.01' required :value="old('purchase_taka')" placeholder='Purchase Taka'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='fuel_cost' label='Fuel Cost' type='number' step='0.01' :value="old('fuel_cost')" placeholder='Fuel Cost'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='fuel_pump' label='Fuel Pump' :value="old('fuel_pump')" placeholder='Fuel Pump'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='diesel_litter' label='Diesel Litre' type='number' step='0.01' :value="old('diesel_litter')" placeholder='Diesel Litre'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='diesel_rate' label='Diesel Rate' type='number' step='0.01' :value="old('diesel_rate')" placeholder='Diesel Rate'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='factory_name' label='Factory Name' :value="old('factory_name')" placeholder='Factory Name'/>
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