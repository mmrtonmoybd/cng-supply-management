@extends('boilerplate::layout.index', [
    'title' => 'Cng Pump Slip',
    'subtitle' => 'Filter Cng Pump Slip',
    'breadcrumb' => [
        'Cng Pump Slip' => 'backend.factory.cngpump.filter',
        'Filter' => 'backend.factory.cngpump.filter'
    ]
])

@include('components.datatable-highlight-css')
@section('content')

@if(isset($results) && $results->count() > 0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Cng Pump Slip">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-industry"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Cng Pump Slip</span>
                <span class="info-box-number">
                  {{ $dbtotal }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        
        <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total load m3">
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
            <div class="info-box" data-toggle="tooltip" title="Total purchase taka">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total purchase taka</span>
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
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-truck-loading"></i></span>

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
            <div class="info-box" data-toggle="tooltip" title="Total difference m3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total difference m3</span>
                <span class="info-box-number">
                  {{ $dbtotaldifference_m3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total difference taka">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-comments-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total difference taka</span>
                <span class="info-box-number">
                  {{ $dbtotaldifference_taka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total cash recive">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total cash recive</span>
                <span class="info-box-number">
                  {{ $dbtotalcash_receipt_amount }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total balance">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total balance</span>
                <span class="info-box-number">
                  {{ $dbtotalbalance }}
                  (@php 
                            if (($dbtotalbalance) > 0) {
                                echo 'Advance';
                            } elseif ($dbtotalbalance == 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp)
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
            <a href="{{ route('backend.factory.cngpump.index') }}" class="btn btn-default" data-toggle="tooltip" title="Filter Cng Pump Slip lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

<x-boilerplate::card>
    <form action="{{ route('backend.factory.cngpump.showFilter') }}" method="GET">
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
                $factoryOptions = \App\Models\Factory::distinct()->where('type', 'CNG Pump Slip')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            @endphp
            <lebel for="factory_id"><b>Factory Name</b></label>
            <select name="factory_id" class="form-control">
                <option value="">Select Factory Name</option>
                @foreach ($factoryOptions as $key => $value)
                    <option value="{{ $key }}" @if (request('factory_id') == $key) selected @endif>{{ $value }}</option>
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
                <a href="{{ route('backend.factory.cngpump.filter') }}" class="btn btn-secondary">
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
                        <th>Bill NO</th>
                        <th>Bill Date</th>
                        <th>FM3</th>
                        <th>Rate</th>
                        <th>FTK</th>
                        <th>Difference Taka</th>
                        <th>Difference M3</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Invoice no</th>
                        <th>Invoice date</th>
                        <th>Cash Receipt Amount</th>
                        <th>Cash Receipt Date</th>
                        <th>Receive by</th>
                        <th>Balance</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalM3 = 0;
                        $totalPurchaseTaka = 0;
                        $totalFM3 = 0;
                        $totalFTK = 0;
                        $totalDifferenceTaka = 0;
                        $totalDifferenceM3 = 0;
                        $totalCashReceiptAmount = 0;
                        $totalBalance = 0;
                    @endphp
                    @foreach($results as $key => $row)
                        @php
        $highlightColor = \App\Models\Highlight::where('module_name', 'cngpump')
                        ->where('module_id', $row->id)
                        ->value('color');

        $highlightClass = ($highlightColor && $highlightColor !== 'none') ? 'highlight-' . $highlightColor : '';
    @endphp
    <tr class="{{ $highlightClass }}">
                            <td>{{ $key + 1}}</td>
                            <td>{{ $row->date ? (\Carbon\Carbon::parse($row->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->vehicle_reg_number }}</td>
                            <td>{{ $row->pumpname ? $row->pumpname->name : '' }}</td>
                            <td>{{ $row->cng_purchase_m3 }}</td>
                            <td>{{ $row->lrate }}</td>
                            <td>{{ $row->purchase_taka }}</td>
                            <td>{{ $row->bill_no }}</td>
                            <td>{{ $row->bill_date }}</td>
                            <td>{{ $row->fm3 }}</td>
                            <td>{{ $row->rate }}</td>
                            <td>{{ $row->ftk }}</td>
                            <td>{{ $row->difference_taka }}</td>
                            <td>{{ $row->difference_m3 }}</td>
                            <td>{{ $row->in }}</td>
                            <td>{{ $row->out }}</td>
                            @php
                            $invoice_id = '';
                            if ($row->invoice_id) {
                                $invoice = \App\Models\Invoice::find($row->invoice_id);
                                $invoice_id = $invoice->invoice_number;
                                }
                            @endphp
                            <td>{{ $invoice_id }}</td>
                            <td>{{ $row->invoice_date ? (\Carbon\Carbon::parse($row->invoice_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->cash_receipt_amount }}</td>
                            <td>{{ $row->cash_receipt_date ? (\Carbon\Carbon::parse($row->cash_receipt_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->recived_by }}</td>
                            <td></td>
                            <td>{{ $row->remarks }}</td>
                        </tr>
                        @php
                            $totalM3 += $row->cng_purchase_m3;
                            $totalPurchaseTaka += $row->purchase_taka;
                            $totalFM3 += $row->fm3;
                            $totalFTK += $row->ftk;
                            $totalDifferenceTaka += $row->difference_taka;
                            $totalDifferenceM3 += $row->difference_m3;
                            $totalCashReceiptAmount += $row->cash_receipt_amount;
                            $totalBalance += $row->balance;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format($totalM3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($totalPurchaseTaka, 2) }}</th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format($totalFM3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($totalFTK, 2) }}</th>
                        <th>{{ number_format($totalDifferenceTaka, 2) }}</th>
                        <th>{{ number_format($totalDifferenceM3, 2) }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format($totalCashReceiptAmount, 2) }}</th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format(($dbtotalbalance), 2) }}(@php 
                            if (($dbtotalbalance) > 0) {
                                echo 'Advance';
                            } elseif ($dbtotalbalance === 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp)</th>
                            <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</x-boilerplate::card>
@endsection

@push('css')
@include('components.datatable-print-css')
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
@include('components.datatable-export-js')
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
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
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
            showDropdowns: true,
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

    window.initExportableDataTable('.table');
});
</script>
@endpush
