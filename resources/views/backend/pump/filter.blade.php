@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Filter Pumps',
    'breadcrumb' => [
        'Pump' => 'backend.pump.index',
        'Filter' => 'backend.pump.filter'
    ]
])

@section('content')

@if(isset($results) && $results->count() > 0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
    <div class="row">

    <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total pump">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-gas-pump"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total pump</span>
                <span class="info-box-number">
                  {{ $dbtotalpump }}
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
                  {{ $dbtotal_m3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total m3 purchase taka">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total m3 purchase taka</span>
                <span class="info-box-number">
                  {{ $dbtotal_purchase_taka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total Diesel purchase taka">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Diesel purchase taka</span>
                <span class="info-box-number">
                  {{ $dieselsum }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total purchase taka">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total purchase taka</span>
                <span class="info-box-number">
                  {{ $dieselsum + $dbtotal_purchase_taka }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total payment">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-comments-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total payment taka</span>
                <span class="info-box-number">
                  {{ $dbtotal_payment }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-sm-4">
            <div class="info-box" data-toggle="tooltip" title="Total balance(All payment - All purchase)">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-balance-scale-right"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total balance</span>
                <span class="info-box-number">
                  {{ $dbtotal_payment - ($dieselsum + $dbtotal_purchase_taka) }} 
                  (@php 
                            if (($dbtotal_payment - ($dbtotal_purchase_taka + $dieselsum)) > 0) {
                                echo 'Advance';
                            } elseif ($dbtotal_payment - ($dbtotal_purchase_taka + $dieselsum) == 0) {
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
            <a href="{{ route('backend.pump.index') }}" class="btn btn-default" data-toggle="tooltip" title="Pump lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

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
            <div class="col-md-4">
                <x-boilerplate::select2 name="type" :allow-clear=true label="Pump type" :value="request('type')" placeholder="Select Pump type">
                    <option value="">All</option>
                    <option value="1" {{ request('type') === '1' ? 'selected' : '' }}>Main</option>
                    <option value="0" {{ request('type') === '0' ? 'selected' : '' }}>Third party</option>
                </x-boilerplate::select2>
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
            <table id="transportTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Car No</th>
                        <th>Pump Name</th>
                        @if (request('type') === '0')
                        <th>Third party pump name</th>
                        @endif
                        <th>M3</th>
                        <th>Rate</th>
                        <th>Purchase Taka</th>
                        <th>Diesel</th>
                        <th>Payment Date</th>
                        <th>Payment</th>
                        <th>Balance</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPayment = 0;
                        $totalBalance = 0;
                        $totalM3 = 0;
                        $totalPurchaseTaka = 0;
                    @endphp
                    @foreach($results as $key => $pump)
                        @php
                            $totalPayment += $pump->payment ?? 0;
                            $totalBalance += $pump->balance ?? 0;
                            $totalM3 += $pump->cng_purchase_m3 ?? 0;
                            $totalPurchaseTaka += $pump->purchase_taka ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pump->date ? (\Carbon\Carbon::parse($pump->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $pump->vehicle_reg_number ?? 'N/A' }}</td>
                            <td>{{ $pump->pumpname->name ?? 'N/A' }}</td>
                            @if (request('type') === '0')
                            <td>{{ $pump->third_party_pump_name }}</td>
                            @endif
                            
                            <td>{{ $pump->cng_purchase_m3 ?? 'N/A' }}</td>
                            <td>{{ $pump->rate ?? 'N/A' }}</td>
                            <td>{{ $pump->purchase_taka ?? 'N/A' }}</td>
                            <td></td>
                            <td>{{ $pump->payment_date ? (\Carbon\Carbon::parse($pump->payment_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $pump->payment ?? 'N/A' }}</td>
                            <td></td>
                            <td>{{ $pump->remarks }}</td>
                            
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
                        <th></th>
                        <th class="text-right">Total</th>
                        @if (request('type') === '0')
                        <th></th>
                        @endif
                        <th>{{ $totalM3 }}</th>
                        <th></th>
                        <th>{{ $totalPurchaseTaka }}</th>
                        <th>{{ $dieselsum }}</th>
                        <th></th>
                        <th>{{ $totalPayment }}</th >
                        
                        <th>{{ $totalPayment - ($totalPurchaseTaka + $dieselsum) }} 
                            (@php 
                            if (($totalPayment - ($totalPurchaseTaka + $dieselsum)) > 0) {
                                echo 'Advance';
                            } elseif ($totalPayment - ($totalPurchaseTaka + $dieselsum) == 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp)</th>

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
@include('components.datatable-print-css')
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />

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
    $('#pump_name').select2({
        placeholder: 'Select Pump Name',
        allowClear: true,
        width: '100%'
    });
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

    window.initExportableDataTable('#transportTable');
});
</script>
@endpush