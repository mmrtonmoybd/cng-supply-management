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
  @php
    $isToday = !request()->filled('daterange') ? 'Today' : '';
    $isLast = !request()->filled('daterange') ? 'Last' : '';
    $lastdate = $handcash?->date ? \Carbon\Carbon::parse($handcash->date)->format('d-m-Y') : '';
  @endphp

  @ability('admin', 'load_crud,pump_crud,dispansar_crud,weightone_crud,weight_crud,cngpump_crud,diesel_crud,transport_crud,vehicle_income_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-coins',
      'bg' => 'primary',
      'title' => "$isToday Profit",
      'tooltip' => 'Dispansar + Cng Pump & Weight Scale + Weight scale + CNG Pump Slip + Transport rent - (Pump + Diesel + Transport cost)',
      'value' => $profit
    ])

    @include('backend.partials.infobox', [
      'icon' => 'fas fa-dollar-sign',
      'bg' => 'danger',
      'title' => "$isToday Total sale",
      'tooltip' => 'Total sale(Dispansar + Cng Pump & Weight Scale + Weight Scale + Cng Pump Slip)',
      'value' => $profit_dispansar + $profit_weightone + $profit_weight + $profit_cngpump
    ])
  @endability

  @ability('admin', 'vehicle_income_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-car',
      'bg' => 'warning',
      'title' => "$isToday Vehicle income",
      'tooltip' => 'Vehicle income profit',
      'value' => $load_m3
    ])
  @endability

  @ability('admin', 'load_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-truck-loading',
      'bg' => 'success',
      'title' => "$isToday Load m3",
      'tooltip' => 'Total load m3(Main + third party)',
      'value' => $load_m3
    ])
  @endability

  @ability('admin', 'diesel_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-oil-can',
      'bg' => 'danger',
      'title' => "$isToday Diesel cost",
      'tooltip' => 'Diesel purchase cost',
      'value' => $diesel_cost
    ])
  @endability

  @ability('admin', 'pump_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-gas-pump',
      'bg' => 'info',
      'title' => "$isToday Pay pump",
      'tooltip' => 'Total pay to pump(Main + third party)',
      'value' => $pay_pump
    ])

    @include('backend.partials.infobox', [
      'icon' => 'fas fa-gas-pump',
      'bg' => 'secondary',
      'title' => "$isToday pump ($total_due_type)",
      'tooltip' => 'Total pump(Main + third party) + Diesel',
      'value' => $total_due
    ])
  @endability

  @ability('admin', 'diesel_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-oil-can',
      'bg' => 'warning',
      'title' => "$isToday Diesel liter ($use_liter_type)",
      'tooltip' => "diesel purchase litre - Use liter ($use_liter_type)",
      'value' => $use_liter
    ])

    @include('backend.partials.infobox', [
      'icon' => 'fas fa-oil-can',
      'bg' => 'primary',
      'title' => "$isToday Diesel balance ($use_balance_type)",
      'tooltip' => "Diesel taka - Diesel use balance ($use_balance_type)",
      'value' => $use_balance
    ])
  @endability

  @ability('admin', 'invoice_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-file-invoice-dollar',
      'bg' => 'success',
      'title' => "$isToday Invoice",
      'tooltip' => 'Invoice',
      'value' => $invoice
    ])
  @endability

  @ability('admin', 'cashbook_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-hand-holding-usd',
      'bg' => 'danger',
      'title' => "$isLast Cash in hand",
      'tooltip' => "Cash in hand - $lastdate",
      'value' => $handcash->balance ?? 0
    ])

    @include('backend.partials.infobox', [
      'icon' => 'fas fa-search-dollar',
      'bg' => 'info',
      'title' => "$isLast Cashbook income",
      'tooltip' => "Cashbook income - $lastdate",
      'value' => $income
    ])

    @include('backend.partials.infobox', [
      'icon' => 'fas fa-funnel-dollar',
      'bg' => 'secondary',
      'title' => "$isLast Cashbook expense",
      'tooltip' => "Cashbook expense - $lastdate",
      'value' => $expense
    ])
  @endability

  @ability('admin', 'transport_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-shuttle-van',
      'bg' => 'warning',
      'title' => "$isToday Transport net income",
      'tooltip' => 'Transport',
      'value' => $transport_income
    ])
  @endability

  @ability('admin', 'vehicle_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-shuttle-van',
      'bg' => 'success',
      'title' => "Total vehicle",
      'tooltip' => 'Which avilable in vehicle section',
      'value' => $totalvehicle
    ])
  @endability

  @ability('admin', 'users_crud')
    @include('backend.partials.infobox', [
      'icon' => 'fas fa-users',
      'bg' => 'warning',
      'title' => "Total users",
      'tooltip' => 'Toatal user',
      'value' => $totaluser
    ])
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

        // Filter out zero/null values
        const filteredData = @json($dailyTotals);
        const filteredLabels = @json($dateLabels);

        // Calculate Incremental Sales Trend
        const trendData = filteredData.map((value, index) => {
            return index === 0 ? value : value - filteredData[index - 1];
        });

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
