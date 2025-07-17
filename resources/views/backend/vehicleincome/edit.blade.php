@extends('boilerplate::layout.index', [
    'title' => 'Vehicle Income',
    'subtitle' => 'Create Vehicle Income',
])

@section('content')
<x-boilerplate::form :route="['backend.vehicleIncome.update', $vehicleincome->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.vehicleIncome.index') }}" class="btn btn-default" data-toggle="tooltip" title="Vehicle Income lists">
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
            <x-boilerplate::input name='rent' label='Rent' type='number' step='0.01' :value="old('rent', $vehicleincome->rent)" placeholder='Rent'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='driver_fooding' label='Driver Fooding' type='number' step='0.01' :value="old('driver_fooding', $vehicleincome->driver_fooding)" placeholder='Driver Fooding'/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-boilerplate::input name='maintenance' label='Maintenance' type='number' step='0.01' :value="old('maintenance', $vehicleincome->maintenance)" placeholder='Maintenance'/>
        </div>
        <div class="col-6">
            <x-boilerplate::input name='other' label='other' type='number' step='0.01' :value="old('other', $vehicleincome->other)" placeholder='other'/>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
