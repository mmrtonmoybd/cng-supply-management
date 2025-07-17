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
            margin: 0 0 2px 0;
            font-weight: 700;
            color: #222;
        }
        .header h2 {
            font-size: 1rem;
            margin: 0 0 2px 0;
            font-weight: 600;
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
            text-align: center;
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
            -webkit-overflow-scrolling: touch;
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

        th {
        
        vertical-align: middle !important;
    }

       @media print {
    /* Force full-page width usage */
    html, body {
        width: 210mm;
        margin: 0;
        padding: 0;
    }

    .row {
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .col-md-6 {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    table {
        width: 100% !important;
        table-layout: fixed;
    }

    th, td {
        word-wrap: break-word;
    }

    /* Prevent shadow/padding that may cause spacing */
    .col-md-6, .header {
        box-shadow: none !important;
        border: none !important;
    }

    .no-print {
        display: none !important;
    }

    @page {
        size: A4 portrait;
        margin: 10mm;
    }
}


@media screen and (max-width: 767px) {
    body {
        padding: 12px;
        background: #f8f9fa;
    }

    .header h1 {
        font-size: 1.5rem;
    }

    .header h2 {
        font-size: 1rem;
    }

    .header p,
    .header .date {
        font-size: 0.9rem;
        text-align: center;
    }

    .row {
        display: block;
        gap: 0;
    }

    .col-md-6 {
        width: 100% !important;
        max-width: 100% !important;
        padding: 12px 0;
        box-shadow: none;
    }

    table {
        font-size: 0.875rem;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
    }

    th, td {
        padding: 6px 10px;
    }
}

    </style>
</head>
<body>
<div id="exportContent">
    <div class="header">
        <h1>Mars Bangla</h1>
        @if (Route::currentRouteName() !== 'backend.categories.filterExport')
        <h2>Cash Ledger</h2>
        @elseif(is_null(request('category_id')))
        <h2>All category of Cash Ledger</h2>
        @elseif(!empty(request('category_id'))) 
        <h2>Cash ledger for category: {{ \App\Models\Category::find(request('category_id'))?->name ?? '' }}</h2>
        @endif
        <p>House #43, Road #03, Sector #03, Uttra, Dhaka-1230</p>
        <div class="date">Date: {{ ($range != '' ) ? invoiceDateStructure($range) :  ( (!empty($calculation->date)) ? \Illuminate\Support\Carbon::parse($calculation->date)->format('l, F j, Y') : '' )}}</div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="section-title">Income</div>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Description</th>
                        <th style="text-align: right;">Sub amount</th>
                        <th style="text-align: right;">Amount</th>
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
                                <td style="padding-left: 2em; text-align: left;">{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                <td style="padding-left: 2em; text-align: left;">{{ $income->description }}</td>
                                <td style="padding-left: 2em; text-align: right;">{{ number_format($income->amount, 2) }}</td>
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
                        <th style="text-align: center;">Date</th>
                        <th style="text-align: center;">Description</th>
                        <th style="text-align: right;">Sub amount</th>
                        <th style="text-align: right;">Amount</th>
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
                                <td style="padding-left: 2em; text-align: left;">{{ (!empty($inc->date)) ? \Illuminate\Support\Carbon::parse($inc->date)->format('d/m/Y') : '' }}</td>
                                <td style="padding-left: 2em; text-align: left;">{{ $expense->description }}</td>
                                <td style="padding-left: 2em; text-align: right;">{{ number_format($expense->amount, 2) }}</td>
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
        @if (Route::currentRouteName() !== 'backend.categories.filterExport')
        <div style="margin-bottom: 8px;"><strong>Previous Balance:</strong> {{ number_format($previousBalance, 2) }}/-</div>
        @endif
            
            <div style="margin-bottom: 8px;"><strong>Total Income:</strong> {{ number_format($totalIncome, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Total Expense:</strong> {{ number_format($totalExpense, 2) }}/-</div>
            <div style="margin-bottom: 8px;"><strong>Net Change (Income - Expense):</strong> {{ number_format($totalIncome - $totalExpense, 2) }}/-</div>
        @if (Route::currentRouteName() !== 'backend.categories.filterExport')
            <div style="margin-bottom: 8px;"><strong>Net Balance (Previous + Net Change):</strong> {{ number_format($previousBalance + $totalIncome - $totalExpense, 2) }}/-</div>
        @endif
        </div>
    </div>
</div>
<div class="no-print" style="text-align:center; margin-top: 20px;">
    <button onclick="window.print()">Print</button>
</div>
</body>
</html>
