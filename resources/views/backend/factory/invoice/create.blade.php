@extends('boilerplate::layout.index', [
    'title' => 'Create Invoice',
    'subtitle' => 'Add New Invoice',
])

@section('content')
<x-boilerplate::form route="backend.factory.invoice.store">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.invoice.index') }}" class="btn btn-default" data-toggle="tooltip" title="Invoice lists">
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
                        @php
                            $defaultDate = old('date') ? old('date') : \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        @endphp
                        <x-boilerplate::input name="date" label="Invoice Date" type="date" value="{{ $defaultDate }}" placeholder="Date" />
                        <small class="form-text text-muted">
                            If no date is selected, the current date will be used.
                        </small>
                    </div>
                    
                    @if (request()->has('factory') && request()->get('factory') == 'dispansar')
                    <div class="col-md-6">
                        @php
                            $dispansarOptions = \App\Models\Dispansar::whereNull('invoice_id')->orderBy('id', 'ASC')->get();
                        @endphp
                        <label for="factories_id">Select Dispansar Items</label>
                        <select name="factories_id[]" id="factories_id" class="form-control select2" multiple required>
                            @foreach ($dispansarOptions as $dispansar)
                                <option value="{{ $dispansar->id }}">
                                    #Bill no: {{ $dispansar->bill_no }} - Factory: {{ $dispansar->factory->name }} - Car no: {{ $dispansar->vehicle_reg_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @elseif (request()->has('factory') && request()->get('factory') == 'weightone')

                    <div class="col-md-6">
                        @php
                            $dispansarOptions = \App\Models\WeightOne::whereNull('invoice_id')->orderBy('id', 'ASC')->get();
                        @endphp
                        <label for="factories_id">Select Cng Pump & Weight Scale Items</label>
                        <select name="factories_id[]" id="factories_id" class="form-control select2" multiple required>
                            @foreach ($dispansarOptions as $dispansar)
                                <option value="{{ $dispansar->id }}">
                                    #Challan no: {{ $dispansar->bill_no }} - Factory: {{ $dispansar->factory->name }} - Car no: {{ $dispansar->vehicle_reg_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @elseif (request()->has('factory') && request()->get('factory') == 'weight')

                    <div class="col-md-6">
                        @php
                            $dispansarOptions = \App\Models\Weight::whereNull('invoice_id')->orderBy('id', 'ASC')->get();
                        @endphp
                        <label for="factories_id">Select Weight scale Items</label>
                        <select name="factories_id[]" id="factories_id" class="form-control select2" multiple required>
                            @foreach ($dispansarOptions as $dispansar)
                                <option value="{{ $dispansar->id }}">
                                    #Bill no: {{ $dispansar->bill_no }} - Factory: {{ $dispansar->factory->name }} - Car no: {{ $dispansar->vehicle_reg_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @elseif (request()->has('factory') && request()->get('factory') == 'cngpump')

                    <div class="col-md-6">
                        @php
                            $dispansarOptions = \App\Models\CngPump::whereNull('invoice_id')->orderBy('id', 'ASC')->get();
                        @endphp
                        <label for="factories_id">Select CNG Pump Slip Items</label>
                        <select name="factories_id[]" id="factories_id" class="form-control select2" multiple required>
                            @foreach ($dispansarOptions as $dispansar)
                                <option value="{{ $dispansar->id }}">
                                    #Bill no: {{ $dispansar->bill_no }} - Factory: {{ $dispansar->factory->name }} - Car no: {{ $dispansar->vehicle_reg_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @endif

                    <input name="factory" type="text" value="{{  request()->get('factory') }}" required hidden />
                </div>
            </x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection

@push('css')
<!-- Select2 Bootstrap 4 theme CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    /* Custom style for better appearance */
    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 38px;
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush

@push('js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    var dispansarSelect = $('#factories_id');
    dispansarSelect.select2({
        theme: 'bootstrap4',
        placeholder: 'Select Items',
        allowClear: true,
        width: '100%',
        templateResult: function (data) {
            if (!data.id) {
                return data.text;
            }
            // Hide already selected options from dropdown
            var selected = dispansarSelect.val() || [];
            if (selected.includes(data.id)) {
                return null;
            }
            return data.text;
        }
    });
});
</script>
@endpush
