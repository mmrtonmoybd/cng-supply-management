@extends('boilerplate::layout.index', [
    'title' => 'Dispenser',
    'subtitle' => 'Filter Dispensers',
    'breadcrumb' => [
        'Dispenser' => 'backend.factory.dispansar.index',
        'Filter' => 'backend.factory.dispansar.filter'
    ]
])

@section('content')
<x-boilerplate::card>
    <form action="{{ route('backend.factory.dispansar.showFilter') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                @php
                $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <lebel for="pumpName_id"><b>Pump Name</b></label>
            <select name="pumpName_id" class="form-control">
                <option value="">Select Pump Name</option>
                @foreach ($pumpOptions as $key => $value)
                    <option value="{{ $key }}" @if (request('pumpName_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
            </div>
            <div class="col-md-3">
                @php
                $factoryOptions = \App\Models\Factory::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <lebel for="factory_id"><b>Factory Name</b></label>
            <select name="factory_id" class="form-control">
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if (request('factory_id') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
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
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                <a href="{{ route('backend.factory.dispansar.filter') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Clear Filters
                </a>
            </div>
        </div>
    </form>

    @if(isset($results) && $results->count() > 0)
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped" id="dispansarTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Load Date</th>
                        <th>Car No</th>
                        <th>Pump Name</th>
                        <th>M3</th>
                        <th>Rate (Load)</th>
                        <th>Purchase Taka</th>
                        <th>Bill No</th>
                        <th>Bill Date</th>
                        <th>Opening Reading</th>
                        <th>Closing Reading</th>
                        <th>Total Reading</th>
                        <th>Rate (Dispansar)</th>
                        <th>Bill Amount</th>
                        <th>Difference M3</th>
                        <th>Difference Taka</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Cash Receipt Date</th>
                        <th>Cash Receipt Amount</th>
                        <th>Balance</th>
                        <th>Received By</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sumM3 = $sumPurchaseTaka = $sumOpening = $sumClosing = $sumTotal = $sumBill = $sumDiffM3 = $sumDiffTaka = $sumCash = $sumBalance = 0;
                    @endphp
                    @foreach($results as $key => $dispansar)
                        @php
                            $sumM3 += $dispansar->cng_purchase_m3 ?? 0;
                            $sumPurchaseTaka += $dispansar->purchase_taka ?? 0;
                            $sumOpening += $dispansar->opening_reading ?? 0;
                            $sumClosing += $dispansar->closing_reading ?? 0;
                            $sumTotal += $dispansar->total_reading ?? 0;
                            $sumBill += $dispansar->bill_amount ?? 0;
                            $sumDiffM3 += $dispansar->difference_m3 ?? 0;
                            $sumDiffTaka += $dispansar->difference_taka ?? 0;
                            $sumCash += $dispansar->cash_receipt_amount ?? 0;
                            $sumBalance += $dispansar->balance ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $dispansar->date ? (\Carbon\Carbon::parse($dispansar->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $dispansar->vehicle_reg_number }}</td>
                            <td>{{ $dispansar->pumpname ? $dispansar->pumpname->name : '' }}</td>
                            <td>{{ $dispansar->cng_purchase_m3 }}</td>
                            <td>{{ $dispansar->rate }}</td>
                            <td>{{ $dispansar->purchase_taka }}</td>
                            <td>{{ $dispansar->bill_no }}</td>
                            <td>{{ $dispansar->bill_date }}</td>
                            <td>{{ $dispansar->opening_reading }}</td>
                            <td>{{ $dispansar->closing_reading }}</td>
                            <td>{{ $dispansar->total_reading }}</td>
                            <td>{{ $dispansar->rate }}</td>
                            <td>{{ $dispansar->bill_amount }}</td>
                            <td>{{ $dispansar->difference_m3 }}</td>
                            <td>{{ $dispansar->difference_taka }}</td>
                            <td>{{ $dispansar->in }}</td>
                            <td>{{ $dispansar->out }}</td>
                            <td>{{ $dispansar->cash_receipt_date ? (\Carbon\Carbon::parse($dispansar->cash_receipt_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $dispansar->cash_receipt_amount }}</td>
                            <td></td>
                            <td>{{ $dispansar->recived_by }}</td>
                            <td>{{ $dispansar->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th></th>
                        <th></th>
                        <th>{{ $sumM3 }}</th>
                        <th></th>
                        <th>{{ $sumPurchaseTaka }}</th>
                        <th></th>
                        <th></th>
                        <th>{{ $sumOpening }}</th>
                        <th>{{ $sumClosing }}</th>
                        <th>{{ $sumTotal }}</th>
                        <th></th>
                        <th>{{ $sumBill }}</th>
                        <th>{{ $sumDiffM3 }}</th>
                        <th>{{ $sumDiffTaka }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ $sumCash }}</th>
                        <th>{{ $sumCash - $sumBill}}(@php 
                            if (($sumCash - $sumBill) > 0) {
                                echo 'Advance';
                            } elseif ($sumCash - $sumBill == 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            
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
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
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
    $('#dispansarTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Dispenser Filter Results',
                filename: 'dispenser-filter-results-{{ date('Ymd_His') }}',
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'pdfHtml5',
                title: 'Dispenser Filter Results',
                filename: 'dispenser-filter-results-{{ date('Ymd_His') }}',
                exportOptions: { columns: ':visible' },
                footer: true,
                orientation: 'landscape',
                pageSize: 'A3'
            },
            {
                extend: 'print',
                title: 'Dispenser Filter Results',
                exportOptions: { columns: ':visible' },
                footer: true
            }
        ],
        paging: false,
        searching: false,
        ordering: false,
        info: false
    });
});
</script>
@endpush
