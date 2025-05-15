@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Filter Loads',
    'breadcrumb' => [
        'Load' => 'backend.load.index',
        'Filter' => 'backend.load.filter'
    ]
])

@section('content')
<x-boilerplate::card>
    <form action="{{ route('backend.load.showFilter') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                <x-boilerplate::select2 name="pump_name" label="Pump Name" :value="request('pump_name')" placeholder="Select Pump Name">
                    @foreach($pumpNames as $name)
                        <option value="{{ $name }}" {{ request('pump_name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </x-boilerplate::select2>
            </div>
            <div class="col-md-3">
                <x-boilerplate::input name="car_no" type="text" label="Car Number" :value="request('car_no')" placeholder="Enter Car Number"/>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_range">Date Range</label>
                    <input type="text" class="form-control" id="date_range" name="date_range" value="{{ request('date_range') }}" placeholder="Select Date Range">
                </div>
            </div>
            <div class="col-md-3">
                <x-boilerplate::select2 name="status" label="Status" :value="request('status')" placeholder="Select Status">
                    <option value="">All</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Use</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Not Use</option>
                </x-boilerplate::select2>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('backend.load.filter') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Clear Filters
                </a>
            </div>
        </div>
    </form>

    @if(isset($results) && $results->count() > 0)
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Car No</th>
                        <th>Pump Name</th>
                        <th>M3</th>
                        <th>Rate</th>
                        <th>Purchase Taka</th>
                        <th>Factory Name</th>
                        <th>Status</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalM3 = 0;
                        $totalPurchaseTaka = 0;
                    @endphp
                    @foreach($results as $load)
                        @php
                            $totalM3 += $load->cng_purchase_m3 ?? 0;
                            $totalPurchaseTaka += $load->purchase_taka ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $load->date ?? 'N/A' }}</td>
                            <td>{{ $load->vehicle_reg_number ?? 'N/A' }}</td>
                            <td>{{ $load->pump_name ?? 'N/A' }}</td>
                            <td>{{ $load->cng_purchase_m3 ?? 'N/A' }}</td>
                            <td>{{ $load->rate ?? 'N/A' }}</td>
                            <td>{{ $load->purchase_taka ?? 'N/A' }}</td>
                            <td>{{ $load->factory_name ?? 'N/A' }}</td>
                            <td>
                                @if($load->status == 1)
                                    <span class="badge badge-success">Use</span>
                                @else
                                    <span class="badge badge-danger">Not Use</span>
                                @endif
                            </td>
                            <td>{{ $load->remark ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th>{{ $totalM3 }}</th>
                        <th></th>
                        <th>{{ $totalPurchaseTaka }}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
            @if(method_exists($results, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $results->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    @elseif(isset($results))
        <div class="alert alert-info mt-4">
            No results found for the applied filters.
        </div>
    @endif
</x-boilerplate::card>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    $('#pump_name').select2({
        placeholder: 'Select Pump Name',
        allowClear: true,
        width: '100%'
    });
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });
    @if(request('date_range'))
        var dates = '{{ request('date_range') }}'.split(' - ');
        $('#date_range').data('daterangepicker').setStartDate(dates[0]);
        $('#date_range').data('daterangepicker').setEndDate(dates[1]);
        $('#date_range').val('{{ request('date_range') }}');
    @endif
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
@endpush
