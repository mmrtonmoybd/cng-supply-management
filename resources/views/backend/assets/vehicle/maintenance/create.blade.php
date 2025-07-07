@extends('boilerplate::layout.index', [
    'title' => 'Vehicle maintenance',
    'subtitle' => 'Create Vehicle maintenance',
])

@section('content')
<x-boilerplate::form route='backend.vehicle.vehiclemaintenance.store'>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.vehicle.vehiclemaintenance.index') }}" class="btn btn-default" data-toggle="tooltip" title="Vehicle lists">
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
        <div class="col-md-6">
           <x-boilerplate::select2 name='vehicle_id' model='App\\Models\\Vehicle|vehicle_number|id'  label='Vehicle' required :selected="old('vehicle_id')" placeholder='Select Vehicle'/>
        </div>
        <div class="col-md-6">
            <x-boilerplate::input name='maintenance_cost' required label='Taka' type='number' step='0.001' :value="old('maintenance_cost')" placeholder='Taka'/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-boilerplate::input name='details' label='Details' type='textarea' :value="old('details')" placeholder='Details'/>
        </div>
        <div class="col-md-6">
            <x-boilerplate::input name='maintenance_date' required label='Maintenance Date' type='date' :value="old('maintenance_date')" placeholder='Maintenance Date'/>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
