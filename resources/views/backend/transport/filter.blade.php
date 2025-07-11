@extends('boilerplate::layout.index', [
    'title' => 'Transport',
    'subtitle' => 'Filter Transport',
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
                <span class="info-box-text">Total transport</span>
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
                  {{ number_format($totals['new_balance'], 2) }} 
(@php 
    if ($totals['balance'] > 0) {
        echo 'Advance';
    } elseif ($totals['balance'] == 0) {
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

    <form method="GET" action="{{ route('backend.transport.showFilter') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_range">Date Range</label>
                    <input type="text" class="form-control" id="date_range" name="date_range" value="{{ request('date_range') }}" placeholder="Select Date Range">
                </div>
            </div>
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
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-group">
                    <button type="submit" name="filter" value="1" class="btn btn-primary">Filter</button>
                    <a href="{{ route('backend.transport.filter') }}" class="btn btn-default">Reset</a>
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
                            <th>Date</th>
                            <th>Vehicle No</th>
                            <th>From</th>
                            <th>To</th>
                            <th class="text-right">Rent</th>
                            <th class="text-right">Maintenance</th>
                            <th class="text-right">Diesel</th>
                            <th class="text-right">Toll</th>
                            <th class="text-right">Labour</th>
                            <th class="text-right">Chada</th>
                            <th class="text-right">Fooding</th>
                            <th class="text-right">Police</th>
                            <th class="text-right">Parking</th>
                            <th class="text-right">Other</th>
                            <th class="text-right">Total Cost</th>
                            <th class="text-right">Net Income</th>
                            <th>Cash Receipt Amount</th>
                            <th>Cash Receipt Date</th>
                            <th>Balance</th>
                            <th>Remarks</th>
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
                                <td>{{ $transport->date ? date('d-m-Y', strtotime($transport->date)) : '-' }}</td>
                                <td>{{ $transport->vehicle->vehicle_number ?? '-' }}</td>
                                <td>{{ $transport->from }}</td>
                                <td>{{ $transport->to }}</td>
                                <td class="text-right">{{ number_format($transport->rent, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->maintenance_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->diesel_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->toll_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->labour_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->chada_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->fooding_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->police_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->parking_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($transport->other_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($total_cost, 2) }}</td>
                                <td class="text-right">{{ number_format($net_income, 2) }}</td>
                                <td>{{ $transport->cash_receipt_amount }}</td>
                                <td>{{ $transport->cash_receipt_date ? (\Carbon\Carbon::parse($transport->cash_receipt_date)->format('d-m-Y')) : 'N/A' }}</td>
                                <td></td>
                                <td>{{ $transport->remarks }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total:</th>
                            <th class="text-right">{{ number_format($totals['rent'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['maintenance_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['diesel_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['toll_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['labour_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['chada_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['fooding_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['police_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['parking_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['other_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['total_cost'], 2) }}</th>
                            <th class="text-right">{{ number_format($totals['net_income'], 2) }}</th>

                            <th class="text-right">{{ number_format($totals['cash_receipt_amount'], 2) }}</th>
                            <th class="text-right"></th>
                            <th class="text-right">{{ number_format($totals['new_balance'], 2) }} 
(@php 
    if ($totals['balance'] > 0) {
        echo 'Advance';
    } elseif ($totals['balance'] == 0) {
        echo 'Paid';
    } else {
        echo 'Due';
    }
@endphp)</th>
                            <th class="text-right"></th>
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
