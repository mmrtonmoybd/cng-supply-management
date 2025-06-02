<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashbook Export</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 32px;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .header h1 {
            font-size: 2rem;
            margin: 0 0 4px 0;
            font-weight: 700;
            color: #222;
        }
        .header p {
            margin: 0;
            color: #555;
            font-size: 1rem;
        }
        .header .date {
            font-size: 1rem;
            color: #888;
            margin-top: 8px;
            text-align: right;
        }
        .row {
            display: flex;
            gap: 32px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .col-md-6 {
            flex: 1 1 420px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 24px 18px 18px 18px;
            margin-bottom: 32px;
            min-width: 350px;
            max-width: 600px;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        th, td {
            border-bottom: 1px solid #e0e0e0;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #f1f3f6;
            font-weight: 600;
            color: #333;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .category-row td {
            background: #f8f9fa;
            font-weight: 600;
            color: #007bff;
            border-bottom: 1px solid #e0e0e0;
        }
        .total-row td {
            font-weight: 700;
            background: #f1f3f6;
            color: #222;
            border-top: 2px solid #007bff;
        }
        @media print {
            body { background: #fff; margin: 0; padding: 0; }
            .row {
                display: table;
                width: 100%;
                table-layout: fixed;
                gap: 0;
            }
            .col-md-6 {
                display: table-cell;
                vertical-align: top;
                width: 50%;
                box-shadow: none;
                page-break-inside: avoid;
                margin: 0;
                min-width: unset;
                max-width: unset;
                padding: 0 10px 0 0;
            }
            .header, .row, .col-md-6, table, th, td {
                page-break-inside: avoid !important;
                break-inside: avoid;
            }
            .no-print { display: none; }
            html, body {
                width: 100%;
                height: 100%;
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>
<div id="exportContent">
    <div class="header">
        <h1>Mars Bangla</h1>
        <p>House #43, Road #03, Sector #03, Uttra, Dhaka-1230</p>
        <div class="date">Date: {{ ($range != '' ) ? $range :  ( (!empty($calculation->date)) ? \Illuminate\Support\Carbon::parse($calculation->date)->format('d/m/Y') : '' )}}</div>
    </div>
    @if(isset($dateRange) && $dateRange)
        <div class="alert alert-info">
            <strong>Date Range:</strong> {{ $dateRange }}
        </div>
    @elseif(isset($range) && $range)
        <div class="alert alert-info">
            <strong>Date Range:</strong> {{ $range }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="section-title">Income</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Sub amount</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                @php $totalIncome = 0; @endphp
                @foreach($incomeEntries->groupBy('category_id') as $category_id => $entries)
                    @php
                        $categoryTotal = $entries->sum('amount');
                        $entryCount = $entries->count();
                    @endphp
                    @if($category_id)
                        <tr class="category-row">
                            <td colspan="2">{{ $entries->first()->category->name }}</td>
                            <td></td>
                            <td></td>
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
                <tr class="total-row">
                    <td colspan="3">Total:</td>
                    <td style="text-align: right;">{{ number_format((int)$previousBalance + $totalIncome, 2) }}/-</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div class="section-title">Expense</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Sub amount</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                @php $totalExpense = 0; @endphp
                @foreach($expenseEntries->groupBy('category_id') as $category_id => $entries)
                    @php
                        $categoryTotal = $entries->sum('amount');
                        $entryCount = $entries->count();
                    @endphp
                    @if($category_id)
                        <tr class="category-row">
                            <td colspan="2">{{ $entries->first()->category->name }}</td>
                            <td></td>
                            <td></td>
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
                <tr class="total-row">
                    <td colspan="3">Total:</td>
                    <td style="text-align: right;">{{ number_format($totalExpense, 2) }}/-</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 32px;">
        <div class="col-md-6">
            <div style="margin-bottom: 8px;"><strong>Previous Balance:</strong> {{ number_format($previousBalance, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Total Income:</strong> {{ number_format($totalIncome, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Total Expense:</strong> {{ number_format($totalExpense, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Net Change (Income - Expense):</strong> {{ number_format($totalIncome - $totalExpense, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Net Balance (Previous + Net Change):</strong> {{ number_format($previousBalance + $totalIncome - $totalExpense, 2) }}/-</div>
        </div>
    </div>
</div>
<div style="text-align: center; margin: 20px 0; color: #555; font-size: 0.9rem;">
    Developed by Engineer BD Network
</div>
<div class="no-print" style="text-align:center; margin-top: 20px;">
    <button onclick="window.print()">Print</button>
</div>
</body>
</html>
