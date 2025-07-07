@extends('boilerplate::layout.index', [
    'title' => 'Cashbook',
    'subtitle' => 'Cashbook',
    'breadcrumb' => [
        'Cashbook' => 'backend.calculations.index',
    ]
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.calculations.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
    </div>
</div>
@if(isset($dateRange) && $dateRange)
<div class="row">
    <div class="col-12">
        <x-boilerplate::card>
            <form action="{{ route('backend.calculations.filter') }}" method="GET" class="mb-0">
                <div class="row">
                    <div class="col-md-8">
                        <label for="date_range">Date Range</label>
                        <input type="text" name="date_range" id="date_range" class="form-control" value="{{ $dateRange }}" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter by Date</button>
                    </div>
                </div>
            </form>
        </x-boilerplate::card>
    </div>
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });
    @if(isset($dateRange) && $dateRange)
        var dates = '{{ $dateRange }}'.split(' - ');
        $('#date_range').data('daterangepicker').setStartDate(dates[0]);
        $('#date_range').data('daterangepicker').setEndDate(dates[1]);
        $('#date_range').val('{{ $dateRange }}');
    @endif
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
@endpush
@endif
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">
                @if(isset($dateRange) && $dateRange)
                    Filtered Cashbook
                @else
                    Cashbook Details
                @endif
            </h4>
            @if ($previousBalance > 0)
            <!---
            <div class="alert border rounded alert-light">
                <h5>Previous Balance: <strong>{{ number_format($previousBalance, 2) }}</strong></h5>
            </div>
            --->
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h5 class="text-success"><strong>Income</strong></h5>
                        @php $totalIncome = 0; @endphp
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Sub amount</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($incomeEntries->groupBy('category_id') as $category_id => $entries)
                                @php
                                    $categoryTotal = $entries->sum('amount');
                                    $entryCount = $entries->count();
                                @endphp
                                @if($category_id)
                                    <tr>
                                        <td colspan="4" class="text-primary font-weight-bold">{{ $entries->first()->category->name }}</td>
                                    </tr>
                                    @foreach($entries as $i => $income)
                                        @php $inc = \App\Models\Calculation::where('id', $income->calculation_id)->first(); @endphp
                                        <tr>
                                            <td style="padding-left: 2em;">{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                            <td style="padding-left: 2em;">{{ $income->description }}</td>
                                            <td style="padding-left: 2em;">{{ number_format($income->amount, 2) }}</td>
                                            <td style="padding-left: 2em; text-align: right;">
                                                @if ($i == $entryCount - 1)
                                                    {{ number_format($categoryTotal, 2) }}
                                                    @php $totalIncome += $categoryTotal; @endphp
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($entries as $income)
                                        @php $inc = \App\Models\Calculation::where('id', $income->calculation_id)->first(); @endphp
                                        <tr>
                                            <td>{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $income->description }}</td>
                                            <td></td>
                                            <td style="text-align: right;">{{ number_format($income->amount, 2) }} @php $totalIncome += $income->amount; @endphp</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <h6><strong>Total Income:</strong> {{ number_format($totalIncome, 2) }}</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h5 class="text-danger"><strong>Expense</strong></h5>
                        @php $totalExpense = 0; @endphp
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Sub amount</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($expenseEntries->groupBy('category_id') as $category_id => $entries)
                                @php
                                    $categoryTotal = $entries->sum('amount');
                                    $entryCount = $entries->count();
                                @endphp
                                @if($category_id)
                                    <tr>
                                        <td colspan="4" class="text-primary font-weight-bold">{{ $entries->first()->category->name }}</td>
                                    </tr>
                                    @foreach($entries as $i => $expense)
                                        @php $inc = \App\Models\Calculation::where('id', $expense->calculation_id)->first(); @endphp
                                        <tr>
                                            <td style="padding-left: 2em;">{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                            <td style="padding-left: 2em;">{{ $expense->description }}</td>
                                            <td style="padding-left: 2em;">{{ number_format($expense->amount, 2) }}</td>
                                            <td style="padding-left: 2em; text-align: right;">
                                                @if ($i == $entryCount - 1)
                                                    {{ number_format($categoryTotal, 2) }}
                                                    @php $totalExpense += $categoryTotal; @endphp
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($entries as $expense)
                                        @php $inc = \App\Models\Calculation::where('id', $expense->calculation_id)->first(); @endphp
                                        <tr>
                                            <td>{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $expense->description }}</td>
                                            <td></td>
                                            <td style="text-align: right;">{{ number_format($expense->amount, 2) }} @php $totalExpense += $expense->amount; @endphp</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <h6><strong>Total Expense:</strong> {{ number_format($totalExpense, 2) }}</h6>
                    </div>
                </div>
            </div>
            <div class="border rounded bg-light mt-4">
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Total Income</th>
                            <td>{{ number_format($totalIncome, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Expense</th>
                            <td>{{ number_format($totalExpense, 2) }}</td>
                        </tr>
                        @if ($previousBalance > 0)
                        <tr>
                            <th>Previous Balance</th>
                            <td>{{ number_format($previousBalance, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Net Balance</th>
                            <td>
                                @php
                                    $netChange = $totalIncome - $totalExpense;
                                    $netBalance = $previousBalance + $netChange;
                                @endphp
                                {{ number_format($netBalance, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <h5>Calculation Details:</h5>
                <p>
             @if ($previousBalance > 0) <strong>Previous Balance:</strong> {{ number_format($previousBalance, 2) }}<br>@endif
                    <strong>+/- Income - Expense:</strong> {{ number_format($totalIncome, 2) }} - {{ number_format($totalExpense, 2) }} = {{ number_format($netChange, 2) }}<br>
                    <strong>Final Net Balance:</strong> {{ number_format($previousBalance, 2) }} + {{ number_format($netChange, 2) }} = <strong>{{ number_format($netBalance, 2) }}</strong>
                </p>
            </div>
        </x-boilerplate::card>
        <div class="d-flex justify-content-end mt-3 gap-2">
            
            @if(isset($dateRange) && $dateRange)
                <a href="{{ route('backend.calculations.filterExport', ['date_range'=> $dateRange]) }}" target="_blank" class="btn btn-primary">Export</a>
            @elseif(isset($calculation) && $calculation)
                <a href="{{ route('backend.export', $calculation->id) }}?start_date={{$startDate}}&end_date={{$endDate}}" target="_blank" class="btn btn-primary">Export</a>
            @endif
        </div>
       
    </div>
</div>
@endsection