@extends('boilerplate::layout.index', [
    'title' => 'Transport',
    'subtitle' => 'Edit Transport',
])

@section('content')
<x-boilerplate::form :route="['backend.transport.update', $transport->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.transport.index') }}" class="btn btn-default" data-toggle="tooltip" title="Transport lists">
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
        <div class="col-4">
            <x-boilerplate::input name='date' label='Date' type='date' required :value="old('date', $transport->date)" placeholder='Date'/>
        </div>
        <div class="col-4">
            @php
                $vehicleOptions = \App\Models\Vehicle::orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray();
            @endphp
            <label for="vehicle_id">Vehicle</label>
            <select name="vehicle_id" class="form-control" required>
                <option value="">Select Vehicle</option>
                @foreach ($vehicleOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('vehicle_id', $transport->vehicle_id) == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='from' label='From' required :value="old('from', $transport->from)" placeholder='From'/>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <x-boilerplate::input name='to' label='To' required :value="old('to', $transport->to)" placeholder='To'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='rent' label='Rent Income' type='number' step='0.001' :value="old('rent', $transport->rent)" placeholder='Rent Income'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='maintenance_cost' label='Maintenance Cost' type='number' step='0.001' :value="old('maintenance_cost', $transport->maintenance_cost)" placeholder='Maintenance Cost'/>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <x-boilerplate::input name='diesel_cost' label='Diesel Cost' type='number' step='0.001' :value="old('diesel_cost', $transport->diesel_cost)" placeholder='Diesel Cost'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='toll_cost' label='Toll Cost' type='number' step='0.001' :value="old('toll_cost', $transport->toll_cost)" placeholder='Toll Cost'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='labour_cost' label='Labour Cost' type='number' step='0.001' :value="old('labour_cost', $transport->labour_cost)" placeholder='Labour Cost'/>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <x-boilerplate::input name='chada_cost' label='Chada Cost' type='number' step='0.001' :value="old('chada_cost', $transport->chada_cost)" placeholder='Chada Cost'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='fooding_cost' label='Fooding Cost' type='number' step='0.001' :value="old('fooding_cost', $transport->fooding_cost)" placeholder='Fooding Cost'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='police_cost' label='Police Cost' type='number' step='0.001' :value="old('police_cost', $transport->police_cost)" placeholder='Police Cost'/>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <x-boilerplate::input name='parking_cost' label='Parking Cost' type='number' step='0.001' :value="old('parking_cost', $transport->parking_cost)" placeholder='Parking Cost'/>
        </div>
        <div class="col-4">
            <x-boilerplate::input name='other_cost' label='Other Cost' type='number' step='0.001' :value="old('other_cost', $transport->other_cost)" placeholder='Other Cost'/>
        </div>

        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date', $transport->cash_receipt_date)" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.001" :value="old('cash_receipt_amount', $transport->cash_receipt_amount)" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" type="text" :value="old('recived_by', $transport->recived_by)" placeholder="Received By" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="remarks" label="Remarks" type="text" :value="old('remarks', $transport->remarks)" placeholder="Remarks" />
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
