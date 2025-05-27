@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Filter Pumps',
    'breadcrumb' => [
        'Pump' => 'backend.pump.index',
        'Filter' => 'backend.pump.filter'
    ]
])

@section('content')
<x-boilerplate::card>
    <form action="{{ route('backend.pump.showFilter') }}" method="GET">
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4">
                <x-boilerplate::input name="car_no" type="text" label="Car Number" :value="request('car_no')" placeholder="Enter Car Number"/>
            </div>
            <div class="col-md-4">
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
                <a href="{{ route('backend.pump.filter') }}" class="btn btn-secondary">
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
                        <th>Payment Date</th>
                        <th>Payment</th>
                        <th>Balance</th>
                        <th>Balance Type</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPayment = 0;
                        $totalBalance = 0;
                        $totalM3 = 0;
                    @endphp
                    @foreach($results as $pump)
                        @php
                            $totalPayment += $pump->payment ?? 0;
                            $totalBalance += $pump->balance ?? 0;
                            $totalM3 += $pump->loada->cng_purchase_m3 ?? 0;
                            $totalPurchaseTaka += $pump->loada->purchase_taka ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $pump->loada->date ?? 'N/A' }}</td>
                            <td>{{ $pump->loada->vehicle_reg_number ?? 'N/A' }}</td>
                            <td>{{ $pump->loada->pumpname->name ?? 'N/A' }}</td>
                            <td>{{ $pump->loada->cng_purchase_m3 ?? 'N/A' }}</td>
                            <td>{{ $pump->loada->rate ?? 'N/A' }}</td>
                            <td>{{ $pump->loada->purchase_taka ?? 'N/A' }}</td>
                            <td>{{ $pump->payment_date ?? 'N/A' }}</td>
                            <td>{{ $pump->payment ?? 'N/A' }}</td>
                            <td></td>
                            <td>
                                @php
                                    $balance = $pump->balance;
                                @endphp
                                @if(is_null($balance))
                                    {{-- No badge --}}
                                @elseif($balance == 0)
                                    <span class="badge badge-success">Paid</span>
                                @elseif($balance < 0)
                                    <span class="badge badge-warning">Advance</span>
                                @else
                                    <span class="badge badge-danger">Due</span>
                                @endif
                            </td>
                            <!--
                            <td>
                                @if(auth()->user()->ability(['admin'], 'pump_crud'))
                                    <a href="{{ route('backend.pump.show', $pump->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                                @if(auth()->user()->ability(['admin'], 'pump_crud'))
                                    <a href="{{ route('backend.pump.edit', $pump->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            </td>
                            -->
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th>{{ $totalM3 }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ $totalPayment }}</th>
                        <th>{{ $totalPayment - $totalPurchaseTaka }} (
                            @php 
                            if (($totalPayment - $totalPurchaseTaka) < 0) {
                                echo 'Advance';
                            } elseif ($totalPayment - $totalPurchaseTaka == 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp
                            )</th>
                        <th></th>
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
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
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

    // DataTable export buttons
    var now = new Date();
    var dateStr = now.getFullYear() + '-' + (now.getMonth()+1).toString().padStart(2, '0') + '-' + now.getDate().toString().padStart(2, '0') + '_' + now.getHours().toString().padStart(2, '0') + now.getMinutes().toString().padStart(2, '0') + now.getSeconds().toString().padStart(2, '0');
    var fileName = 'pump-filter-' + dateStr;
    var table = $('.table.table-bordered').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Pump Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'pdfHtml5',
                title: 'Pump Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'print',
                title: 'Pump Filter Results',
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