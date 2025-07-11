@extends('boilerplate::layout.index', [
    'title' => 'Diesel',
    'subtitle' => 'Diesel create',
])

@section('content')
<x-boilerplate::form route='backend.diesel.store'>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.diesel.index') }}" class="btn btn-default" data-toggle="tooltip" title="Diesel lists">
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
                        <x-boilerplate::input name='d_date' label='Load Date' type='date' :value="old('d_date')" placeholder='Diesel Date'/>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='d_time' label='Load Time' type='time' :value="old('d_time')" placeholder='Diesel Time'/>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='slip_no' label='Slip No' :value="old('slip_no')" placeholder='Slip No'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        @php
                            $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                        @endphp
                        <label for="pumpName_id">Pump Name</label>
                        <select name="pumpName_id" class="form-control">
                            <option value="">Select Pump Name</option>
                            @foreach ($pumpOptions as $key => $value)
                                <option value="{{ $key }}" @if (old('pumpName_id') == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='vehicle_reg_number' label='Car No' required :value="old('vehicle_reg_number')" placeholder='Car No'/>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='diesel_purchase_litre' label='Diesel Purchase (Litre)' type='number' step='0.001' :value="old('diesel_purchase_litre')" placeholder='Diesel Purchase (Litre)'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-boilerplate::input name='taka' label='Taka' type='number' step='0.001' :value="old('taka')" placeholder='Taka'/>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='date' label='Usage Date' type='date' :value="old('date')" placeholder='Usage Date'/>
                    </div>
                    <div class="col-md-4">
                        <x-boilerplate::input name='time' label='Usage Time' type='time' :value="old('time')" placeholder='Usage Time'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-boilerplate::input name='distance' label='Distance (km)' type='number' step='0.001' :value="old('distance')" placeholder='Distance'/>
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
$(document).ready(function() {
    // Auto calculate on form submit
    $('form').on('submit', function(e) {
        var dieselLitreInput = $('[name="diesel_purchase_litre"]');
        var takaInput = $('[name="taka"]');
        var litre = parseFloat(dieselLitreInput.val() || 0);
        var taka = parseFloat(takaInput.val() || 0);
        var factorBalance = parseFloat('{{ settings()->get('factor_balance') }}');

        // Only calculate if one field is empty and the other has a value
        if (!litre && taka && factorBalance) {
            // If taka is input but diesel_purchase_litre is empty
            dieselLitreInput.val((taka / factorBalance).toFixed(2));
        } else if (!taka && litre && factorBalance) {
            // If diesel_purchase_litre is input but taka is empty
            takaInput.val((litre * factorBalance).toFixed(2));
        }
        // If both are empty or both have values, do nothing
    });
});
</script>
@endpush