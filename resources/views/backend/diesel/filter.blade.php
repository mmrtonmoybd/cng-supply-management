@extends('boilerplate::layout.index', [
    'title' => 'Diesel',
    'subtitle' => 'Diesel Filter',
    'breadcrumb' => [
        'Diesel' => 'backend.diesel.index'
    ]
])

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endpush

@section('content')
<x-boilerplate::card>
    <x-slot name="header">
        Filter Diesel
    </x-slot>

    <form method="GET" action="{{ route('backend.diesel.filter') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_range">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" placeholder="Select date range">
                    <input type="hidden" name="from_date" id="from_date" value="{{ request('from_date') }}">
                    <input type="hidden" name="to_date" id="to_date" value="{{ request('to_date') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @php
                        $pumpOptions = \App\Models\PumpName::distinct()->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                    @endphp
                    <label for="pumpName_id">Pump Name</label>
                    <select name="pumpName_id" class="form-control">
                        <option value="">Select Pump Name</option>
                        @foreach ($pumpOptions as $key => $value)
                            <option value="{{ $key }}" @if(request('pumpName_id') == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group">
                    @php
                        $vehicleOptions = \App\Models\Vehicle::orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray();
                    @endphp
                    <label for="vehicle_id">Vehicle</label>
                    <select name="vehicle_id" class="form-control">
                        <option value="">Select Vehicle</option>
                        @foreach ($vehicleOptions as $key => $value)
                            <option value="{{ $key }}" @if(request('vehicle_id') == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">                <div class="form-group">
                    <button type="submit" name="filter" value="1" class="btn btn-primary">Filter</button>
                    <a href="{{ route('backend.diesel.filter') }}" class="btn btn-default">Reset</a>
                </div>
            </div>
        </div>
    </form>
</x-boilerplate::card>

@if(isset($diesels) && request('filter'))
<div class="row">
    <div class="col-12">
        <x-boilerplate::card>
            <div class="table-responsive">
                <table id="dieselTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Load Date</th>
                            <th>Pump Name</th>
                            <th>Vehicle</th>
                            <th class="text-right">Diesel Purchase (Litre)</th>
                            <th class="text-right">Taka</th>
                            <th class="text-right">Distance</th>
                            <th class="text-right">Use Litre</th>
                            <th class="text-right">Use Balance</th>
                            <th class="text-right">Due/Advance Litre</th>
                            <th class="text-right">Due/Advance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diesels as $key => $diesel)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $diesel->d_date ? date('d-m-Y', strtotime($diesel->d_date)) : '-' }}</td>
                            <td>{{ $diesel->pumpname->name ?? '-' }}</td>
                            <td>{{ $diesel->vehicle->vehicle_number ?? '-' }}</td>
                            <td class="text-right">{{ number_format($diesel->diesel_purchase_litre, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->taka, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->distance ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->use_litre ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->use_balance ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->diesel_purchase_litre - ($diesel->use_litre ?? 0), 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->taka - ($diesel->use_balance ?? 0), 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th class="text-right">Total:</th>
                            <th></th>
                            <th></th>
                            <th class="text-right">{{ number_format($diesels->sum('diesel_purchase_litre'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('taka'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('distance'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('use_litre'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('use_balance'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('diesel_purchase_litre') - $diesels->sum('use_litre'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('taka') - $diesels->sum('use_balance'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-boilerplate::card>    </div>
</div>
@endif

@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
$(function() {
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    @if(request('from_date') && request('to_date'))
        start = moment("{{ request('from_date') }}");
        end = moment("{{ request('to_date') }}");
    @endif

    function cb(start, end) {
        $('#date_range').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        $('#from_date').val(start.format('YYYY-MM-DD'));
        $('#to_date').val(end.format('YYYY-MM-DD'));
    }

    $('#date_range').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    // Initialize DataTable with export buttons
    var now = new Date();
    var dateStr = now.getFullYear() + '-' + 
                 (now.getMonth()+1).toString().padStart(2, '0') + '-' + 
                 now.getDate().toString().padStart(2, '0') + '_' + 
                 now.getHours().toString().padStart(2, '0') + 
                 now.getMinutes().toString().padStart(2, '0') + 
                 now.getSeconds().toString().padStart(2, '0');
    var fileName = 'diesel-filter-' + dateStr;

    $('.table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Diesel Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'pdfHtml5',
                title: 'Diesel Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true,
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                title: 'Diesel Filter Results',
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
@endsection
