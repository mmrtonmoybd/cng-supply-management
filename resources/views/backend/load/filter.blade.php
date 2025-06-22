@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Filter Loads',
    'breadcrumb' => [
        'Load' => 'backend.load.index',
        'Filter' => 'backend.load.filter'
    ]
])

@section('content')

@if(isset($results) && $results->count() > 0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total load">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total load</span>
                <span class="info-box-number">
                  {{ $dbtotal_load }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        
        <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total load m3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total load purchase m3</span>
                <span class="info-box-number">
                  {{ $dbtotal_m3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total load purchase">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total load purchase taka</span>
                <span class="info-box-number">
                  {{ $dbtotal_purchase_taka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

    </div>
    </div>
    </div>
</div>

@endif

<div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.load.index') }}" class="btn btn-default" data-toggle="tooltip" title="Load lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>
<x-boilerplate::card>
    <form action="{{ route('backend.load.showFilter') }}" method="GET">
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
            <table class="table table-bordered table-striped" id="dispansarTable">
                <thead>
                    <tr>
                        <th>SL</th>
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
                    @foreach($results as $key => $load)
                        @php
                            $totalM3 += $load->cng_purchase_m3 ?? 0;
                            $totalPurchaseTaka += $load->purchase_taka ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $load->date ? (\Carbon\Carbon::parse($load->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $load->vehicle_reg_number ?? 'N/A' }}</td>
                            <td>{{ $load->pumpname->name ?? 'N/A' }}</td>
                            <td>{{ $load->cng_purchase_m3 ?? 'N/A' }}</td>
                            <td>{{ $load->rate ?? 'N/A' }}</td>
                            <td>{{ $load->purchase_taka ?? 'N/A' }}</td>
                            <td>{{ $load->factory->name ?? 'N/A' }}</td>
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
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right">Total</th>
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
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />

<style>
    #dispansarTable th, #dispansarTable td {
        white-space: nowrap;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
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
    var fileName = 'load-filter-' + dateStr;
    var table = $('.table.table-bordered').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Load Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'pdfHtml5',
                title: 'Load Filter Results',
                filename: fileName,
                exportOptions: { columns: ':visible' },
                footer: true
            },
            {
                extend: 'print',
                title: 'Load Filter Results',
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
