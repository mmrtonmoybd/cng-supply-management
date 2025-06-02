<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Trip Export</title>    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --text-color: #2c3e50;
            --border-color: #ddd;
            --background-color: #fff;
        }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: var(--background-color); 
            margin: 0; 
            padding: 40px;
            color: var(--text-color);
        }
        .header { 
            text-align: center; 
            margin-bottom: 40px; 
            padding: 20px;
            border-bottom: 2px solid var(--border-color);
        }
        .header h1 { 
            font-size: 2.2rem; 
            margin: 0 0 8px 0; 
            font-weight: 700; 
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p { 
            margin: 0; 
            color: var(--secondary-color); 
            font-size: 1.1rem; 
        }
        .header .date { 
            font-size: 1rem; 
            color: var(--secondary-color); 
            margin-top: 12px; 
            text-align: right;
            font-weight: 500;
        }
        .table-responsive { 
            width: 100%; 
            overflow-x: auto;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .trip-table, .cost-table { 
            width: 100%; 
            border-collapse: collapse; 
            min-width: 500px;
            background: var(--background-color);
        }
        .trip-table th, .trip-table td, .cost-table th, .cost-table td { 
            border: 1px solid var(--border-color); 
            padding: 12px 15px; 
            text-align: left; 
        }
        .trip-table th, .cost-table th { 
            background: var(--primary-color); 
            font-weight: 600; 
            color: white;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        .cost-table th, .cost-table td { 
            text-align: center; 
        }
        .cost-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .section-title { 
            font-size: 1.4rem; 
            font-weight: 600; 
            margin-bottom: 20px; 
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--accent-color);
        }
        .sign-row { 
            margin-top: 50px; 
            display: flex; 
            justify-content: space-between; 
            flex-wrap: nowrap;
            padding-top: 30px;
            border-top: 2px solid var(--border-color);
        }
        .sign-col { 
            width: 24%; 
            min-width: 120px; 
            text-align: center; 
            font-size: 1rem; 
            color: var(--text-color); 
            margin-bottom: 10px;
            position: relative;
        }
        .sign-col:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 25%;
            width: 50%;
            height: 1px;
            background: var(--border-color);
        }
        .balance-highlight {
            background-color: #f8f9fa;
            font-weight: bold;
        }        @media (max-width: 900px) {
            body { padding: 20px; }
            .sign-row { flex-wrap: wrap; gap: 20px; }
            .sign-col { 
                width: 45%; 
                min-width: 120px; 
                margin-bottom: 20px;
            }
            .header h1 { font-size: 1.8rem; }
            .section-title { font-size: 1.2rem; }
            .trip-table, .cost-table { font-size: 0.95rem; }
        }
        @media (max-width: 600px) {
            body { padding: 15px; }
            .trip-table th, .trip-table td, .cost-table th, .cost-table td { 
                padding: 8px 10px; 
                font-size: 0.9rem; 
            }
            .header { 
                margin-bottom: 25px;
                padding: 15px;
            }
            .section-title { margin-bottom: 15px; }
            .trip-table, .cost-table { min-width: 400px; }
            .sign-row { 
                flex-wrap: wrap; 
                gap: 15px;
                margin-top: 30px;
            }
            .sign-col { 
                width: 100%; 
                min-width: 120px; 
                margin-bottom: 15px;
            }
            .header h1 { font-size: 1.5rem; }
        }
        @media (max-width: 480px) {
            body { padding: 10px; }
            .trip-table, .cost-table { min-width: 320px; }
            .header h1 { font-size: 1.3rem; }
            .header p { font-size: 0.9rem; }
        }
        @media print {            body { 
                background: #fff !important; 
                margin: 0 !important; 
                padding: 25px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            .header { 
                margin-bottom: 25px !important;
                padding: 15px !important;
            }
            .section-title { 
                margin-bottom: 15px !important;
                color: var(--primary-color) !important;
            }
            .sign-row { 
                margin-top: 40px !important; 
                display: flex !important; 
                flex-direction: row !important; 
                justify-content: space-between !important; 
                flex-wrap: nowrap !important;
                page-break-inside: avoid !important;
            }
            .sign-col { 
                width: 24% !important; 
                min-width: 80px !important; 
                font-size: 0.9rem !important; 
                margin-bottom: 0 !important;
            }
            .trip-table, .cost-table { 
                font-size: 0.9rem !important;
                page-break-inside: avoid !important;
            }
            .trip-table th, .cost-table th {
                background-color: var(--primary-color) !important;
                color: white !important;
            }
            .table-responsive {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <h1>M/S Musafir Motors</h1>
    <p>Sector # 03, Road # 03, House # 43, Uttara, Dhaka-1230</p>
    <div class="date">Date: {{ $transport->date ? (\Carbon\Carbon::parse($transport->date)->format('d-m-Y')) : '' }}</div>
</div>
<div class="section-title">Trip Information</div>
<div class="table-responsive">
<table class="trip-table">
    <tr>
        <th>Trip No.</th>
        <td>{{ $transport->id }}</td>
        <th>Date</th>
        <td>{{ $transport->date ? (\Carbon\Carbon::parse($transport->date)->format('d-m-Y')) : '' }}</td>
    </tr>
    <tr>
        <th>Vehicle No.</th>
        <td>{{ $transport->vehicle->vehicle_number ?? '' }}</td>
        <th>Driver Name</th>
        <td>{{ $transport->vehicle->driver_name ?? '' }}</td>
    </tr>
    <tr>
        <th>Trip from</th>
        <td>{{ $transport->from }}</td>
    </tr>
    <tr>
        <th>Trip Destination</th>
        <td colspan="3">{{ $transport->to }}</td>
    </tr>
</table>
</div>
<div class="section-title">Accounts</div>
<div class="table-responsive">
<table class="cost-table">
    <thead>
        <tr>
            <th>Name Of Account's</th>
            <th>Income Amount</th>
            <th>Expense Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Rent</td><td>{{ $transport->rent }}</td><td></td></tr>
        <tr><td>Diesel</td><td></td><td>{{ $transport->diesel_cost }}</td></tr>
        <tr><td>Fooding</td><td></td><td>{{ $transport->fooding_cost }}</td></tr>
        <tr><td>Toll</td><td></td><td>{{ $transport->toll_cost }}</td></tr>
        <tr><td>Labour</td><td></td><td>{{ $transport->labour_cost }}</td></tr>
        <tr><td>Chada</td><td></td><td>{{ $transport->chada_cost }}</td></tr>
        <tr><td>Police</td><td></td><td>{{ $transport->police_cost }}</td></tr>
        <tr><td>Parking</td><td></td><td>{{ $transport->parking_cost }}</td></tr>
        <tr><td>Maintenance</td><td></td><td>{{ $transport->maintenance_cost }}</td></tr>
        <tr><td>Others</td><td></td><td>{{ $transport->other_cost }}</td></tr>
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
        <tr>
            <td colspan="2"><strong>Grand Total (Income - Expense)</strong></td>
            <td><strong>{{ $transport->rent - (
                ($transport->diesel_cost ?? 0) +
                ($transport->fooding_cost ?? 0) +
                ($transport->toll_cost ?? 0) +
                ($transport->labour_cost ?? 0) +
                ($transport->chada_cost ?? 0) +
                ($transport->police_cost ?? 0) +
                ($transport->parking_cost ?? 0) +
                ($transport->maintenance_cost ?? 0) +
                ($transport->other_cost ?? 0)
            ) }}</strong></td>
        </tr>
    </tbody>
</table>
</div>
<div class="table-responsive">
<table class="trip-table" style="margin-top: 24px;">    <tr><th>Balance</th><td style="font-weight: bold; font-size: 1.1em;">{{ $transport->rent - $transport->total_cost }}</td></tr>
</table>
</div>

<div class="sign-row" style="margin-top: 80px;">
    <div class="sign-col">Prepared By</div>
    <div class="sign-col">Check By</div>
    <div class="sign-col">GM</div>
    <div class="sign-col">Approved By</div>
</div>

<div style="text-align: center; margin-top: 30px; color: var(--secondary-color); font-size: 0.9rem;">
    Developed by Engineer BD Network
</div>

<div class="no-print" style="text-align:center; margin-top: 30px;">
    <button onclick="window.print()" style="
        padding: 10px 25px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    ">Print Document</button>
</div>
</body>
</html>
