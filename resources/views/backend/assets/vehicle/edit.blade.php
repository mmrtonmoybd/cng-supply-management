@extends('boilerplate::layout.index', [
    'title' => 'Vehicle',
    'subtitle' => 'Edit Vehicle',
])

@section('content')
<x-boilerplate::form :route="['backend.vehicle.vehicle.update', $vehicle->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.vehicle.vehicle.index') }}" class="btn btn-default" data-toggle="tooltip" title="Vehicle lists">
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
        <div class="col-md-6">
            <x-boilerplate::input name='vehicle_number' label='Vehicle Number' required :value="old('vehicle_number', $vehicle->vehicle_number)" placeholder='Vehicle Number'/>
        </div>
        <div class="col-md-6">
            <x-boilerplate::input name='vehicle_type' label='Vehicle Type' :value="old('vehicle_type', $vehicle->vehicle_type)" :options="['truck' => 'Truck', 'van' => 'Van', 'car' => 'Car']" type="select" placeholder='Vehicle Type'/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-boilerplate::input name='driver_name' label='Driver Name' :value="old('driver_name', $vehicle->driver_name)" placeholder='Driver Name'/>
        </div>
        <div class="col-md-6">
            <x-boilerplate::input name='driver_phone' label='Driver Phone' :value="old('driver_phone', $vehicle->driver_phone)" placeholder='Driver Phone'/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-boilerplate::input name='registration_date' label='Registration Date' type='date' :value="old('registration_date', $vehicle->registration_date)" placeholder='Registration Date'/>
        </div>
        <div class="col-md-6">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="0" @if(old('status', $vehicle->status) == '0') selected @endif>Inactive</option>
                <option value="1" @if(old('status', $vehicle->status) == '1') selected @endif>Active</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <x-boilerplate::input required name='type' label='Type' :value="old('type', $vehicle->type)" :options="['own' => 'Own', 'rent' => 'Rent']" type="select" placeholder='Type'/>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
