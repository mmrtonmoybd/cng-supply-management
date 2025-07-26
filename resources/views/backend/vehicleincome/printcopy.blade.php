<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Income Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .accounts-table th {
            text-align: center;
        }        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 144px; /* Changed from 50px to 144px (1.5 inches = 144 pixels) */
            text-align: center;
        }
        .signature-col {
            flex: 1;
            margin: 0 10px;
            border-top: 1px solid black;
            padding-top: 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MARS BANGLA</h1>
        <p>Address: House #43, Road #03, Sector #03, Uttra, Dhaka-1230</p>
    </div>
<div style="text-align: center; font-family: sans-serif; font-size: 16pt; margin-bottom: 20px;">
  <u>Vehicle income summary</u>
</div>
    
<table class="accounts-table">
        <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Car No</th>
                        <th>Pump Name</th>
                        <th>M3</th>
                        <th>Load Rate</th>
                        <th>Purchase Taka</th>
                        <th>Diesel</th>
                        <th>F Date</th>
                        <th>FM3</th>
                        <th>Rate</th>
                        <th>FTK</th>
                        <th>Difference</th>
                        <th>Net DIfference</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $key => $row)
                        <tr>
                            <td>{{ $key + 1}}</td>
                            <td>{{ $row->date ? (\Carbon\Carbon::parse($row->date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->vehicle_reg_number }}</td>
                            <td>{{ $row->pumpname ? $row->pumpname->name : '' }}</td>
                            <td>{{ $row->cng_purchase_m3 }}</td>
                            <td>{{ $row->lrate }}</td>
                            <td>{{ $row->purchase_taka }}</td>
                            <td></td>
                            <td>{{ $row->bill_date ? (\Carbon\Carbon::parse($row->bill_date)->format('d-m-Y')) : 'N/A' }}</td>
                            <td>{{ $row->fm3 }}</td>
                            <td>{{ $row->rate }}</td>
                            <td>{{ $row->ftk }}</td>
                            <td>{{ $row->difference }}</td>
                        </tr>
                         @if($loop->last)
                        <tr>
                        <th></th>
                        <th class="text-right">Total</th>
                        <th></th>
                        <th></th>
                        <th>{{ number_format($dbtotalcng_purchase_m3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalpurchase_taka, 2) }}</th>
                        <th>{{ number_format($dieselsum, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalfm3, 2) }}</th>
                        <th></th>
                        <th>{{ number_format($dbtotalftk, 2) }}</th>
                        <th>{{ number_format($dbtotaldifference, 2) }}</th>
                        <th>{{ number_format($dbtotalnet_difference, 2) }}</th>
                     <tr>
                    @endif
                    @endforeach
                </tbody>
                
                    
                
    </table>


    <table>
        <tr>
            <td><strong>Rent</strong></td>
            <td> {{ $dbtotalrent }}</td>
        </tr>
        <tr>
            <td><strong>Driver fooding</strong></td>
            <td>{{ $dbtotaldriver_fooding }}</td>
        </tr>
        <tr>
            <td><strong>Maintenance</strong></td>
            <td>{{ $dbtotalmaintenance }}</td>
        </tr>
        <tr>
            <td><strong>Other</strong></td>
            <td>{{ $dbtotalother }}</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>Total cost</strong></td>
            <td><strong>{{ $totalcost }}</strong></td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong><font color="red">Net profit</font></strong></td>
            <td><strong><font color="red"><u>{{ $net_profit }}</u></font></strong></td>
        </tr>
    </table>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print</button>
    </div>
</body>
</html>
