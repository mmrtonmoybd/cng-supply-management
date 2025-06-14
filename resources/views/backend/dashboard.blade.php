@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::layout.dashboard'),
    'breadcrumb' => [
        'Dashboard' => 'boilerplate.dashboard',
    ]
])

@push('css')
<style>
    /* Make the chart dynamically responsive */
    .chart-container {
        height: 70vh; /* Adjust height dynamically */
        min-height: 450px; /* Ensure it's tall enough */
    }
</style>
@endpush
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
                <a href="{{ route('boilerplate.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Clear Filters
                </a>
            
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
            <div class="info-box" data-toggle="tooltip" title="Cash in hand - {{ $handcash?->date ?  \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') : '' }}">
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
            <div class="info-box" data-toggle="tooltip" title="Cashbook income - {{ $handcash?->date ? \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') : '' }}">
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
            <div class="info-box" data-toggle="tooltip" title="Cashbook expense - {{ $handcash?->date ? \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') : '' }}">
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

<div class="container-fluid">
    {{-- Form Row --}}
    <div class="row mb-3">
        <div class="col-12">
            <x-boilerplate::card>                
                <div class="chart-container">
                   <canvas id="salesChart"></canvas>
                </div>
            </x-boilerplate::card>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const salesChart = document.getElementById('salesChart');

        // Extract Data from Laravel
        const rawLabels = @json($dateLabels);
        const rawData = @json(collect($dailyTotals)->map(fn($val) => $val ?? 0));

        // Filter out zero/null values
        const filteredData = rawData.filter(value => value > 0);
        const filteredLabels = rawLabels.filter((_, index) => rawData[index] > 0);

        // Calculate Incremental Sales Trend
        const trendData = filteredData.map((value, index) => {
            return index === 0 ? value : value - filteredData[index - 1];
        });
        // Determine bar thickness dynamically
        const totalBars = filteredLabels.length;

        // Dynamically adjust thickness based on data size
        const barThickness = Math.max(4, Math.min(20, 300 / totalBars));

        new Chart(salesChart, {
            type: 'bar',
            data: {
                labels: filteredLabels,
                datasets: [
                    {
                        label: 'Total Daily Sales',
                        type: 'bar',
                        data: filteredData,
                        backgroundColor: 'rgba(13, 110, 253, 1)', // Modern Blue
                        borderColor: 'rgba(0, 0, 0, 0.2)',
                        borderWidth: 2,
                        borderRadius: 4,
                        barThickness: 12,
                        barThickness: barThickness // Dynamically set thickness
                    },
                    {
                        label: 'Sales Trend (Change Over Time)',
                        type: 'line',
                        data: trendData,
                        borderColor: 'rgba(25, 135, 84, 0.9)', // Trend Line in Red
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(25, 135, 84, 0.2)',
                        pointRadius: 6,
                        tension: 0.4,
                        animation: { // Apply animation only here
                            duration: 2000,
                            easing: 'easeOutQuart'
                        }
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 15, bottom: 15 } },
                animation: {
                    duration: 2000, // Smooth Animation
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { size: 16, weight: 'bold' } }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                return `Total: ৳ ${context.parsed.y.toLocaleString('en-BD', { minimumFractionDigits: 2 })}`;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Advanced Sales Analytics',
                        font: { size: 22, weight: 'bold' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales Amount (BDT)',
                            font: { size: 16, weight: 'bold' }
                        },
                        ticks: {
                            callback: (value) => '৳ ' + value.toLocaleString(),
                            font: { size: 14 }
                        }
                    },
                    x: {
                        title: {
                            display: false,
                            text: 'Sales Date',
                            font: { size: 16, weight: 'bold' }
                        },
                        ticks: {
                            font: { size: 14 },
                            autoSkip: false, // Prevent labels from skipping
                            maxRotation: 45, // Rotate for better readability
                            minRotation: 45  // Fix rotation angle
                        },
                        grid: { display: false }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    });
</script>
@endpush
@endsection
