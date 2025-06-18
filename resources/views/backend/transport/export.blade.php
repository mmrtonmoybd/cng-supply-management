<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Trip Export</title>
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
        <h1>M/S Musafir Motors</h1>
        <p>Sector #03, Road #03, House #43,Uttara,Dhaka-1230.</p>
    </div>

    <table>
        <tr>
            <td><strong>Trip No.</strong></td>
            <td>{{ $transport->id }}</td>
            <td><strong>Date</strong></td>
            <td>{{ $transport->date ? (\Carbon\Carbon::parse($transport->date)->format('d-m-Y')) : '' }}</td>
        </tr>
        <tr>
            <td><strong>Vehicle No.</strong></td>
            <td>{{ $transport->vehicle->vehicle_number ?? '' }}</td>
            <td><strong>Driver Name</strong></td>
            <td>{{ $transport->vehicle->driver_name ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Trip from</strong></td>
            <td>{{ $transport->from }}</td>
            <td><strong>Cash recive date</strong></td>
            <td>{{ $transport->cash_receipt_date ? (\Carbon\Carbon::parse($transport->cash_receipt_date)->format('d-m-Y')) : '' }}</td>
        </tr>
        <tr>
            <td><strong>Trip Destination</strong></td>
            <td colspan="3">{{ $transport->to }}</td>
        </tr>
    </table>

    <table class="accounts-table">
        <tr>
            <th>Name Of Account's</th>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
        </tr>
        <tr>
            <td>Rent</td>
            <td></td>
            <td>{{ $transport->rent }}</td>
        </tr>
        <tr>
            <td>Diesel</td>
            <td>{{ $transport->diesel_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Fooding</td>
            <td>{{ $transport->fooding_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Toll</td>
            <td>{{ $transport->toll_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Labour</td>
            <td>{{ $transport->labour_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Chada</td>
            <td>{{ $transport->chada_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Police</td>
            <td>{{ $transport->police_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Parking</td>
            <td>{{ $transport->parking_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Maintenance</td>
            <td>{{ $transport->maintenance_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Others</td>
            <td>{{ $transport->other_cost }}</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong>{{ $transport->rent }}</strong></td>
            <td><strong>{{
                ($transport->diesel_cost ?? 0) +
                ($transport->fooding_cost ?? 0) +
                ($transport->toll_cost ?? 0) +
                ($transport->labour_cost ?? 0) +
                ($transport->chada_cost ?? 0) +
                ($transport->police_cost ?? 0) +
                ($transport->parking_cost ?? 0) +
                ($transport->maintenance_cost ?? 0) +
                ($transport->other_cost ?? 0)
            }}</strong></td>
        </tr>
    </table>

    <table>
        <tr>
            <td><strong>Net income</strong></td>
            <td>{{ ($transport->rent ?? 0) - (
                ($transport->diesel_cost ?? 0) +
                ($transport->fooding_cost ?? 0) +
                ($transport->toll_cost ?? 0) +
                ($transport->labour_cost ?? 0) +
                ($transport->chada_cost ?? 0) +
                ($transport->police_cost ?? 0) +
                ($transport->parking_cost ?? 0) +
                ($transport->maintenance_cost ?? 0) +
                ($transport->other_cost ?? 0)
            ) }}</td>
        </tr>
        <tr>
            <td><strong>Cash Received</strong></td>
            <td>{{ $transport->cash_receipt_amount }}</td>
        </tr>
        <tr>
            <td><strong>Balance(Cash Received - Net income)</strong></td>
            <td>{{ $transport->balance }}</td>
        </tr>
        <tr>
            <td><strong>Cash reveive by</strong></td>
            <td>{{ $transport->recived_by }}</td>
        </tr>
        <tr>
            <td><strong>Note:</strong></td>
            <td>{{ $transport->remarks }}</td>
        </tr>
    </table>

    <div class="signature-row">
        <div class="signature-col">Prepared By</div>
        <div class="signature-col">Check By</div>
        <div class="signature-col">GM</div>
        <div class="signature-col">Approved By</div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print</button>
    </div>
</body>
</html>
