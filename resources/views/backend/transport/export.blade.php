<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Trip Export</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 32px; }
        .header { text-align: center; margin-bottom: 32px; }
        .header h1 { font-size: 2rem; margin: 0 0 4px 0; font-weight: 700; color: #222; }
        .header p { margin: 0; color: #555; font-size: 1rem; }
        .header .date { font-size: 1rem; color: #888; margin-top: 8px; text-align: right; }
        .table-responsive { width: 100%; overflow-x: auto; }
        .trip-table, .cost-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; min-width: 500px; }
        .trip-table th, .trip-table td, .cost-table th, .cost-table td { border: 1px solid #e0e0e0; padding: 8px 10px; text-align: left; }
        .trip-table th, .cost-table th { background: #f1f3f6; font-weight: 600; color: #333; }
        .cost-table th, .cost-table td { text-align: center; }
        .section-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 16px; color: #007bff; }
        .sign-row { margin-top: 40px; display: flex; justify-content: space-between; flex-wrap: nowrap; }
        .sign-col { width: 24%; min-width: 120px; text-align: center; font-size: 0.95rem; color: #555; margin-bottom: 10px; }
        @media (max-width: 900px) {
            body { padding: 8px; }
            .sign-row { flex-wrap: wrap; }
            .sign-col { width: 48%; min-width: 120px; margin-bottom: 8px; }
            .header h1 { font-size: 1.3rem; }
            .section-title { font-size: 1.1rem; }
            .trip-table, .cost-table { font-size: 0.95rem; }
        }
        @media (max-width: 600px) {
            .trip-table th, .trip-table td, .cost-table th, .cost-table td { padding: 4px 4px; font-size: 0.85rem; }
            .header, .section-title { margin-bottom: 10px; }
            .trip-table, .cost-table { min-width: 400px; }
            .sign-row { flex-wrap: wrap; }
            .sign-col { width: 100%; min-width: 120px; margin-bottom: 8px; }
        }
        @media (max-width: 480px) {
            .trip-table, .cost-table { min-width: 320px; }
            .header h1 { font-size: 1rem; }
        }
        @media print {
            body { background: #fff; margin: 0; padding: 0; }
            .no-print { display: none; }
            .header { margin-bottom: 12px; }
            .section-title { margin-bottom: 8px; }
            .sign-row { margin-top: 20px; display: flex !important; flex-direction: row !important; justify-content: space-between !important; flex-wrap: nowrap !important; }
            .sign-col { width: 24% !important; min-width: 80px; font-size: 0.85rem; margin-bottom: 0 !important; }
            .trip-table, .cost-table { font-size: 0.85rem; }
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
<table class="trip-table" style="margin-top: 24px;">
    <tr><th>Balance</th><td>{{ $transport->rent - $transport->total_cost }}</td></tr>
</table>
</div>
<div class="sign-row">
    <div class="sign-col">Prepared By</div>
    <div class="sign-col">Check By</div>
    <div class="sign-col">GM</div>
    <div class="sign-col">Approved By</div>
</div>
<div class="no-print" style="text-align:center; margin-top: 20px;">
    <button onclick="window.print()">Print</button>
</div>
</body>
</html>
