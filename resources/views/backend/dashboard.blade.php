@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::layout.dashboard'),
    'breadcrumb' => [
        'Dashboard' => 'boilerplate.dashboard',
    ]
])

@section('content')
<div class="container-fluid">

    {{--  Form Row --}}
    <div class="row mb-3">
        <div class="col-12">
<x-boilerplate::card>
    <form action="{{ route('boilerplate.dashboard') }}" method="GET">
        <div class="row">
            <div class="col-md-8">
                <x-boilerplate::daterangepicker name="daterange" placeholder='Date range peeker' :start="request()->input('daterange.start') ? request()->input('daterange.start') : \Illuminate\Support\Carbon::now() " :end="request()->input('daterange.end') ? request()->input('daterange.end') : \Illuminate\Support\Carbon::now()" />
            </div>
            <br>
            <div class="col-md-4">
            
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                
            
        </div>
        </div>
        
    </form>
</x-boilerplate::card>
        </div>
    </div>

    {{-- Info Box Card --}}
    <div class="row">
        <div class="col-12">
            
    <div class="row">
          
@ability('admin', 'load_crud,pump_crud,dispansar_crud,weightone_crud,weight_crud,cngpump_crud,diesel_crud,transport_crud', [
    'validate_all' => true,
    'return_type' => 'both'
])
    <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Dispansar + Cng Pump & Weight Scale + Weight scale + CNG Pump Slip + Transport rent - (Pump + Diesel + Transport cost)">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Profit</span>
                <span class="info-box-number">
                  {{ $profit }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'load_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total load m3(Main + third party)">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Load m3</span>
                <span class="info-box-number">
                  {{ $load_m3 }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'diesel_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Diesel purchase cost">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Diesel cost</span>
                <span class="info-box-number">
                  {{ $diesel_cost }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'pump_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total pay to pump(Main + third party)">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-gas-pump"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Pay pump</span>
                <span class="info-box-number">
                  {{ $pay_pump }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'pump_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Total pump(Main + third party) + Diesel">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-gas-pump"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} pump ({{ $total_due_type }})</span>
                <span class="info-box-number">
                  {{ $total_due }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'diesel_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="diesel purchase litre - Use liter ({{ $use_liter_type }})">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-nowrap">{{ !request()->filled('daterange') ? 'Today' : '' }} Diesel liter ({{ $use_liter_type }})</span>
                <span class="info-box-number">
                  {{ $use_liter }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'diesel_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Diesel taka - Diesel use balance ({{ $use_balance_type }})">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-oil-can"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Diesel balance ({{ $use_balance_type }})</span>
                <span class="info-box-number">
                  {{ $use_balance }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

@endability

@ability('admin', 'dispansar_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Dispansar sell">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dumpster-fire"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Dispansar sell</span>
                <span class="info-box-number">
                  {{ $profit_dispansar }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'dispansar_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Dispansar cash recive">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dumpster-fire"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Dispansar cash recive</span>
                <span class="info-box-number">
                  {{ $dispansar_cashrec }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'dispansar_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Dispansar balance({{ $dispansar_balance_t_type }})">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dumpster-fire"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Dispansar balance({{ $dispansar_balance_t_type }})</span>
                <span class="info-box-number">
                  {{ $dispansar_balance_t }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'weightone_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cng Pump & Weight Scale sell">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Cng Pump & Weight Scale sell</span>
                <span class="info-box-number">
                  {{ $profit_weightone }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'weightone_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cng Pump & Weight Scale cash recive">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Cng Pump & Weight Scale cash recive</span>
                <span class="info-box-number">
                  {{ $weightone_cashrec }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'weightone_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cng Pump & Weight Scale balance({{ $weightone_balance_t_type }})">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Cng Pump & Weight Scale balance({{ $weightone_balance_t_type }})</span>
                <span class="info-box-number">
                  {{ $weightone_balance_t }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability


@ability('admin', 'weight_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Weight scale sell">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-weight"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Weight scale sell</span>
                <span class="info-box-number">
                  {{ $profit_weight }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability


@ability('admin', 'weight_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Weight scale cash recive">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-weight"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Weight scale cash recive</span>
                <span class="info-box-number">
                  {{ $weight_cashrec }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'weight_crud')

          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Weight scale balance({{ $weight_balance_t_type }})">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-weight"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Weight scale balance({{ $weight_balance_t_type }})</span>
                <span class="info-box-number">
                  {{ $weight_balance_t }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability


@ability('admin', 'cngpump_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="CNG Pump Slip sell">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-charging-station"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} CNG Pump Slip sell</span>
                <span class="info-box-number">
                  {{ $profit_cngpump }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'cngpump_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="CNG Pump Slip cash recive">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-charging-station"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} CNG Pump Slip cash recive</span>
                <span class="info-box-number">
                  {{ $cngpump_cashrec }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability


@ability('admin', 'cngpump_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="CNG Pump Slip balance({{ $cngpump_balance_t_type }})">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-charging-station"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} CNG Pump Slip balance({{ $cngpump_balance_t_type }})</span>
                <span class="info-box-number">
                  {{ $cngpump_balance_t }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'invoice_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Invoice">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Invoice</span>
                <span class="info-box-number">
                  {{ $invoice }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'cashbook_crud')

           <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cash in hand - {{ \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') }}">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Last' : '' }} Cash in hand</span>
                <span class="info-box-number">
                  {{ $handcash->balance ?? 0  }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'cashbook_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cashbook income - {{ \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') }}">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-search-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Last' : '' }} Cashbook income</span>
                <span class="info-box-number">
                  {{ $income }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'cashbook_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Cashbook expense - {{ \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') }}">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-funnel-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Last' : '' }} Cashbook expense</span>
                <span class="info-box-number">
                  {{ $expense }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

@ability('admin', 'transport_crud')
          <div class="col-12 col-sm-4 col-md-3">
            <div class="info-box" data-toggle="tooltip" title="Transport">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shuttle-van"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{ !request()->filled('daterange') ? 'Today' : '' }} Transport net income</span>
                <span class="info-box-number">
                  {{ $transport_income }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
@endability

    </div>

            

        </div>
    </div>

</div>
@endsection
