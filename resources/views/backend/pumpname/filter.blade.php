@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Filter Pumps summarize',
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
            <a href="{{ route('backend.pumpsum.filter') }}" class="btn btn-default" data-toggle="tooltip" title="Pump summarize">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
</div>

<x-boilerplate::card>
    <form action="{{ route('backend.pumpsum.filter.result') }}" method="GET">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_range">Date Range</label>
                    <input type="text" class="form-control" required id="date_range" name="date_range" value="{{ request('date_range') }}" placeholder="Select Date Range">
                </div>
            </div>
            <div class="col-md-6">
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
                <a href="{{ route('backend.pumpsum.filter') }}" class="btn btn-secondary">
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
                        <th>Pump Name</th>
                        <th>M3</th>
                        <th>Diesel Liter</th>
                        <th>Purchase Taka</th>
                        <th>Diesel Taka</th>
                        <th>Total purchase</th>
                        <th>Payment</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPayment = 0;
                        $totalBalance = 0;
                        $totalM3 = 0;
                        $totalPurchaseTaka = 0;
                        $totalLT = 0;
                        $totalDieselTaka = 0;
                    @endphp
                    @foreach($results as $key => $pump)
                        @php
                            $totalPayment += $pump['payment'] ?? 0;
                            $totalBalance += $pump['balance'] ?? 0;
                            $totalM3 += $pump['cng_purchase_m3'] ?? 0;
                            $totalLT += $pump['diesel_liter'] ?? 0;
                            $totalPurchaseTaka += $pump['purchase_taka'] ?? 0;
                            $totalDieselTaka += $pump['diesel_purchase'] ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pump['name'] }}</td>
                            <td>{{ $pump['cng_purchase_m3'] }}</td>
                            <td>{{ $pump['diesel_liter'] }}</td>
                            <td>{{ $pump['purchase_taka'] }}</td>
                            <td>{{ $pump['diesel_purchase'] }}</td>
                            <td>{{ $pump['purchase_taka'] + $pump['diesel_purchase'] }}</td>
                            <td>{{ $pump['payment'] }}</td>
                            <td>{{ $pump['balance'] }}</td>
                            <td>{{ $pump['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th>{{ $totalM3 }}</th>
                        <th>{{ $totalLT }}</th>
                        <th>{{ $totalPurchaseTaka }}</th>
                        <th>{{ $totalDieselTaka }}</th>
                        <th>{{ $totalPurchaseTaka + $totalDieselTaka }}</th>
                        <th>{{ $totalPayment }}</th>
                        <th>{{ $totalBalance }}</th>
                        <th>
                            @php 
                            if (($totalPayment - ($totalPurchaseTaka + $totalDieselTaka)) > 0) {
                                echo 'Advance';
                            } elseif ($totalPayment - ($totalPurchaseTaka + $totalDieselTaka) == 0) {
                                echo 'Paid';
                            } else {
                                echo 'Due';
                            }
                            @endphp
                            </th>
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

    // DataTable export buttons
    var now = new Date();
    var dateStr = now.getFullYear() + '-' + (now.getMonth()+1).toString().padStart(2, '0') + '-' + now.getDate().toString().padStart(2, '0') + '_' + now.getHours().toString().padStart(2, '0') + now.getMinutes().toString().padStart(2, '0') + now.getSeconds().toString().padStart(2, '0');
    var fileName = 'pump-summary-filter-' + dateStr;
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