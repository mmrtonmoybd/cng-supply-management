@extends('boilerplate::layout.index', [
    'title' => 'Vehicle income',
    'subtitle' => 'Filter Vehicle income',
])

@section('content')

@if(isset($results) && $results->count() > 0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total pump">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-industry"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Vehicle income</span>
                <span class="info-box-number">
                  {{ $dbtotal }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        
        <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total purchase m3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total purchase m3</span>
                <span class="info-box-number">
                  {{ $dbtotalcng_purchase_m3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total m3 purchase taka">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total m3 purchase taka</span>
                <span class="info-box-number">
                  {{ $dbtotalpurchase_taka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Factory m3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Factory m3</span>
                <span class="info-box-number">
                  {{ $dbtotalfm3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total factory taka">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total factory taka</span>
                <span class="info-box-number">
                  {{ $dbtotalftk }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total payment">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-comments-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Difference taka</span>
                <span class="info-box-number">
                  {{ $dbtotaldifference }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

         <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total diesel">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total diesel</span>
                <span class="info-box-number">
                  {{ $dieselsum }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Net difference">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Net difference</span>
                <span class="info-box-number">
                  {{ $dbtotalnet_difference }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Rent">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Rent</span>
                <span class="info-box-number">
                  {{ $dbtotalrent }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Driver fooding">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Driver fooding</span>
                <span class="info-box-number">
                  {{ $dbtotaldriver_fooding }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total maintenance">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Maintaince</span>
                <span class="info-box-number">
                  {{ $dbtotalmaintenance }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total balance">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total balance</span>
                <span class="info-box-number">
                  {{ $net_profit }} 
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
            <a href="{{ route('backend.vehicleIncome.index') }}" class="btn btn-default" data-toggle="tooltip" title="Cng Pump & Weight Scale lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

<x-boilerplate::card>
    <form action="{{ route('backend.vehicleIncome.showFilter') }}" method="GET">
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
                <a href="{{ route('backend.factory.weightone.filter') }}" class="btn btn-secondary">
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
                        <th>SL</th>
                        <th>Date</th>
                        <th>Car No</th>
                        <th>Pump Name</th>
                        <th>M3</th>
                        <th>Load Rate</th>
                        <th>Purchase Taka</th>
                        <th>Diesel</th>
                        <th>F Date</th>
                        <th>FM3</th>
                        <th>Rate</th>
                        <th>FTK</th>
                        <th>Difference</th>
                        <th>Net DIfference</th>
                        <th>Rent</th>
                        <th>Driver fooding</th>
                        <th>Mainenance</th>
                        <th>Other</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $key => $row)
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $row->date ? (\Carbon\Carbon::parse($row->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->vehicle_reg_number }}</td>
                            <td>{{ $row->pumpname ? $row->pumpname->name : '' }}</td>
                            <td>{{ $row->cng_purchase_m3 }}</td>
                            <td>{{ $row->lrate }}</td>
                            <td>{{ $row->purchase_taka }}</td>
                            <td></td>
                            <td>{{ $row->bill_date ? (\Carbon\Carbon::parse($row->bill_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->fm3 }}</td>
                            <td>{{ $row->rate }}</td>
                            <td>{{ $row->ftk }}</td>
                            <td>{{ $row->difference }}</td>
                            <td></td>
                            <td>{{ $row->rent }}</td>
                            <td>{{ $row->driver_fooding }}</td>
                            <td>{{ $row->maintenance }}</td>
                            <td>{{ $row->other }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format($dbtotalcng_purchase_m3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalpurchase_taka, 2) }}</th>
                        <th>{{ number_format($dieselsum, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalfm3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalftk, 2) }}</th>
                        <th>{{ number_format($dbtotaldifference, 2) }}</th>
                        <th>{{ number_format($dbtotalnet_difference, 2) }}</th>
                        <th>{{ number_format($dbtotalrent, 2) }}</th>
                        <th>{{ number_format($dbtotaldriver_fooding, 2) }}</th>
                   <th> {{ number_format($dbtotalmaintenance, 2) }}</th>
                   <th>{{ number_format($dbtotalother, 2) }}</th>
                        <th>{{ number_format(($net_profit), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</x-boilerplate::card>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<style>
    .table th, .table td {
        white-space: nowrap;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .table {
        width: auto !important;
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
    // Initialize select2
    $('#pump_name').select2({
        placeholder: 'Select Pump Name',
        allowClear: true,
        width: '100%'
    });
    // Initialize daterangepicker with setTimeout to ensure input is present
    setTimeout(function() {
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
    }, 200);

    // DataTable export/print with unique file name
    var exportFileName = 'Vehicle_Income_Filter_Export_' + moment().format('YYYYMMDD_HHmmss');
    var table = $('.table').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                footer: true,
                title: exportFileName,
                filename: exportFileName,
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                title: exportFileName,
                filename: exportFileName,
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                footer: true,
                title: exportFileName,
                exportOptions: { columns: ':visible' }
            },
            {
            text: 'Summary Print',
            className: 'btn btn-primary', // Bootstrap style
            action: function (e, dt, node, config) {
                const dateRange = '{{ request('date_range') }}'; // Blade variable (ensure it's escaped correctly)
                const url = "{{ route('backend.vehicleIncome.showFilterPrint') }}?pumpName_id={{ request('pumpName_id') }}&car_no={{ request('car_no') }}&date_range={{ request('date_range') }}";
                window.open(url, '_blank');
            }
        }
        ]
    });
});
</script>
@endpush
