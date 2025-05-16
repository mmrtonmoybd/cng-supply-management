@extends('boilerplate::layout.index', [
    'title' => 'Dispenser',
    'subtitle' => 'Edit Dispenser',
])
@section('content')
<x-boilerplate::form :route="['backend.factory.dispansar.update', $dispansar->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.dispansar.index') }}" class="btn btn-default" data-toggle="tooltip" title="Dispenser lists">
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
                    ->orWhere('id', $dispansar->load_entry_id)
                    ->orderByDesc('id')->get();
            @endphp
            <div class="form-group">
                <label for="load_entry_id">Load ID</label>
                <select name="load_entry_id" id="load_entry_id" class="form-control select2" required>
                    <option value="">Select Load Entry</option>
                    @foreach($loadOptions as $load)
                        <option value="{{ $load->id }}" {{ (string)old('load_entry_id', $dispansar->load_entry_id) === (string)$load->id ? 'selected' : '' }}>
                            Car no: {{ $load->vehicle_reg_number }}, Pump name: {{ $load->pump_name }} & Date: {{ $load->date }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_no" label="Bill No" type="number" :value="old('bill_no', $dispansar->bill_no)" placeholder="Bill No" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="bill_date" label="Bill Date" type="date" :value="old('bill_date', $dispansar->bill_date)" placeholder="Bill Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="opening_reading" label="Opening Reading" type="number" step="0.01" :value="old('opening_reading', $dispansar->opening_reading)" placeholder="Opening Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="closing_reading" label="Closing Reading" type="number" step="0.01" :value="old('closing_reading', $dispansar->closing_reading)" placeholder="Closing Reading" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="rate" label="Rate" type="number" step="0.01" :value="old('rate', $dispansar->rate)" placeholder="Rate" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="in" label="In" type="number" step="0.01" :value="old('in', $dispansar->in)" placeholder="In" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="out" label="Out" type="number" step="0.01" :value="old('out', $dispansar->out)" placeholder="Out" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_date" label="Cash Receipt Date" type="date" :value="old('cash_receipt_date', $dispansar->cash_receipt_date)" placeholder="Cash Receipt Date" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="cash_receipt_amount" label="Cash Receipt Amount" type="number" step="0.01" :value="old('cash_receipt_amount', $dispansar->cash_receipt_amount)" placeholder="Cash Receipt Amount" />
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="recived_by" label="Received By" :value="old('recived_by', $dispansar->recived_by)" placeholder="Received By" />
        </div>
        <div class="col-md-12">
            <x-boilerplate::input name="remarks" label="Remarks" :value="old('remarks', $dispansar->remarks)" placeholder="Remarks" />
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection
