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
<style>
    #dieselTable th, #dieselTable td {
        white-space: nowrap;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .table {
        width: auto !important;
    }
</style>
@include('components.datatable-print-css')
@endpush

@section('content')

@if(isset($diesels) && request('filter'))
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total diesel">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total diesel</span>
                <span class="info-box-number">
                  {{ $dbtotaldiesel }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        
        <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total purchase m3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total diesel liter</span>
                <span class="info-box-number">
                  {{ $dbtotaldiesel_purchase_litre }}
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
                  {{ $dbtotaltaka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Use distance(Km)">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-people-arrows"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total distance(Km)</span>
                <span class="info-box-number">
                  {{ $dbtotaldistance }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total use liter">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total use liter</span>
                <span class="info-box-number">
                  {{ $dbtotaluse_litre }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total use balance">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total use balance</span>
                <span class="info-box-number">
                  {{ $dbtotaluse_balance }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Due/Advance Litre(All purchase liter - All use liter)">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Due/Advance Litre</span>
                <span class="info-box-number">
                  {{ $dbtotaldiesel_purchase_litre - $dbtotaluse_litre }} 
                  (@php 
                            if (($dbtotaldiesel_purchase_litre - $dbtotaluse_litre) < 0) {
                                echo 'Due';
                            } else {
                                echo 'Advance';
                            }
                            @endphp)
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Due/Advance Balance(All purchase taka - All use balance)">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Due/Advance Balance</span>
                <span class="info-box-number">
                  {{ $dbtotaltaka - $dbtotaluse_balance }} 
                  (@php 
                            if (($dbtotaltaka - $dbtotaluse_balance) < 0) {
                                echo 'Due';
                            } else {
                                echo 'Advance';
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
            <a href="{{ route('backend.diesel.index') }}" class="btn btn-default" data-toggle="tooltip" title="Diesel lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

<x-boilerplate::card>
    <x-slot name="header">
        Filter Diesel
    </x-slot>

    <form method="GET" action="{{ route('backend.diesel.filter') }}">
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
                    <x-boilerplate::input name="car_no" type="text" label="Car Number" :value="request('car_no')" placeholder="Enter Car Number"/>
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

@if(isset($diesels) && $diesels->count() > 0 && request('filter'))
<div class="row">
    <div class="col-12">
        <x-boilerplate::card>
            <div class="table-responsive mt-4">
                <table id="dieselTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>                            <th>S/L</th>
                            <th>Load Date</th>
                            <th>Load Time</th>
                            <th>Slip No</th>
                            <th>Pump Name</th>
                            <th>Vehicle</th>
                            <th class="text-right">Diesel Purchase (Litre)</th>
                            <th class="text-right">Taka</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th class="text-right">Distance</th>
                            <th class="text-right">Use Litre</th>
                            <th class="text-right">Use Balance</th>
                            <th class="text-right">Due/Advance Litre</th>
                            <th class="text-right">Due/Advance</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diesels as $key => $diesel)
                        <tr>
                            <td>{{ $key + 1 }}</td>                            <td>{{ $diesel->d_date ? date('d-m-Y', strtotime($diesel->d_date)) : '-' }}</td>
                            <td>{{ $diesel->d_time ? date('h:i A', strtotime($diesel->d_time)) : '-' }}</td>
                            <td>{{ $diesel->slip_no ?? '-' }}</td>
                            <td>{{ $diesel->pumpname->name ?? '-' }}</td>
                            <td>{{ $diesel->vehicle_reg_number }}</td>
                            <td class="text-right">{{ number_format($diesel->diesel_purchase_litre, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->taka, 2) }}</td>
                            <td>{{ $diesel->date ? date('d-m-Y', strtotime($diesel->date)) : '-' }}</td>
                            <td>{{ $diesel->time ? date('h:i A', strtotime($diesel->time)) : '-' }}</td>
                            <td class="text-right">{{ number_format($diesel->distance ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->use_litre ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->use_balance ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->diesel_purchase_litre - ($diesel->use_litre ?? 0), 2) }}</td>
                            <td class="text-right">{{ number_format($diesel->taka - ($diesel->use_balance ?? 0), 2) }}</td>
                            <td>{{ $diesel->remarks }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>                    <tfoot>                        <tr>
                            <th>#</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right">Total:</th>
                            <th class="text-right">{{ number_format($diesels->sum('diesel_purchase_litre'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('taka'), 2) }}</th>
                            <th></th>
                            <th></th>
                            <th class="text-right">{{ number_format($diesels->sum('distance'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('use_litre'), 2) }}</th>
                            <th class="text-right">{{ number_format($diesels->sum('use_balance'), 2) }}</th>                            <th class="text-right">
                                {{ number_format($diesels->sum('diesel_purchase_litre') - $diesels->sum('use_litre'), 2) }}
                                {{ ($diesels->sum('diesel_purchase_litre') - $diesels->sum('use_litre')) < 0 ? '(Due)' : '(Advance)' }}
                            </th>
                            <th class="text-right">
                                {{ number_format($diesels->sum('taka') - $diesels->sum('use_balance'), 2) }}
                                {{ ($diesels->sum('taka') - $diesels->sum('use_balance')) < 0 ? '(Due)' : '(Advance)' }}
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-boilerplate::card>    </div>
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

    // Initialize DataTable with export buttons 
});

window.initExportableDataTable('.table.table-bordered');
</script>
@endpush
@endsection
