@extends('boilerplate::layout.index', [
    'title' => 'Transport',
    'subtitle' => 'Transport summary',
    'breadcrumb' => [
        'Transport' => 'backend.transport.index',
        'Filter' => 'backend.transport.filter'
    ]
])

@push('css')
@include('components.datatable-print-css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<style>
    #transportTable th, #transportTable td {
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

@section('content')

@if(isset($transports) && $transports->count() > 0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total dispansar">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shuttle-van"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total trip</span>
                <span class="info-box-number">
                  {{ $dbtotal }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        
        <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total load m3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck-moving"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rent</span>
                <span class="info-box-number">
                  {{ $totals['rent'] }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total cost">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total cost</span>
                <span class="info-box-number">
                  {{ $totals['total_cost'] }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total income">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-percent"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Income</span>
                <span class="info-box-number">
                  {{ $totals['net_income'] }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total cash recive">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Cash recive</span>
                <span class="info-box-number">
                  {{ $totals['cash_receipt_amount'] }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total balance">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total balance</span>
                <span class="info-box-number">
                  {{ (int) $totals['cash_receipt_amount'] - (int) $totals['net_income'] }} 
(@php 
    if (((int) $totals['cash_receipt_amount'] - (int) $totals['net_income']) > 0) {
        echo 'Advance';
    } elseif (((int) $totals['cash_receipt_amount'] - (int) $totals['net_income']) == 0) {
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
            <a href="{{ route('backend.transport.index') }}" class="btn btn-default" data-toggle="tooltip" title="Transport lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

<x-boilerplate::card>
    <x-slot name="header">
        Filter Transport
    </x-slot>

    <form method="GET" action="{{ route('backend.transport.showSummary') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_range">Date Range</label>
                    <input type="text" class="form-control" required id="date_range" name="date_range" value="{{ request('date_range') }}" placeholder="Select Date Range">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-group">
                    <button type="submit" name="filter" value="1" class="btn btn-primary">Filter</button>
                    <a href="{{ route('backend.transport.summary') }}" class="btn btn-default">Reset</a>
                </div>
            </div>
        </div>
    </form>
</x-boilerplate::card>

@if(isset($transports) && $transports->count() > 0)
<div class="row">
    <div class="col-12">
        <x-boilerplate::card>
            <div class="table-responsive">
                <table id="transportTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Vehicle No</th>
                            <th>Trip</th>
                            <th class="text-right">Rent</th>
                            <th class="text-right">Total Cost</th>
                            <th class="text-right">Net Income</th>
                            <th>Cash Receipt Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transports as $key => $transport)
                            @php
                                $total_cost = $transport->maintenance_cost + $transport->diesel_cost + $transport->toll_cost + 
                                            $transport->labour_cost + $transport->chada_cost + $transport->fooding_cost +
                                            $transport->police_cost + $transport->parking_cost + $transport->other_cost;
                                $net_income = $transport->rent - $total_cost;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                
                                <td>{{ $transport->vehicle->vehicle_number ?? '-' }}</td>
                                <td>{{ $transport->trip_count }}</td>
                                <td class="text-right">{{ number_format($transport->rent, 2) }}</td>
                                <td class="text-right">{{ number_format($total_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($net_income, 2) }}</td>
                                <td>{{ $transport->cash_receipt_amount }}</td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">Total:</th>
                            <th>{{ $dbtotal }}</th>
                            <th class="text-right">{{ number_format($totals['rent'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['total_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['net_income'], 2) }}</th>

                            <th class="text-right">{{ number_format($totals['cash_receipt_amount'], 2) }}</th>
                            <th class="text-right">{{ (int) $totals['cash_receipt_amount'] - (int) $totals['net_income']  }}
(@php 
    if (((int) $totals['cash_receipt_amount'] - (int) $totals['net_income']) > 0) {
        echo 'Advance';
    } elseif (((int) $totals['cash_receipt_amount'] - (int) $totals['net_income']) == 0) {
        echo 'Paid';
    } else {
        echo 'Due';
    }
@endphp)</th>
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-boilerplate::card>
    </div>
</div>
@endif

@push('js')
@include('components.datatable-export-js')
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
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script>
$(function() {
    // Initialize daterangepicker
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });

    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    @if(request('date_range'))
        var dates = '{{ request('date_range') }}'.split(' - ');
        $('#date_range').data('daterangepicker').setStartDate(dates[0]);
        $('#date_range').data('daterangepicker').setEndDate(dates[1]);
    @endif

    // Initialize DataTable with export buttons
    window.initExportableDataTable('#transportTable');
});
</script>
@endpush
@endsection
