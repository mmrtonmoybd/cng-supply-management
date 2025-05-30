<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: #f4f4f4;
    }
    .invoice {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border: 1px solid #ccc;
      position: relative;
    }
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #0078D7;
    }
    .invoice-info {
      text-align: right;
    }
    .invoice-info h2 {
      margin: 0;
    }
    .address-section {
      display: flex;
      justify-content: space-between;
      margin: 20px 0;
    }
    .address {
      width: 48%;
      line-height: 1.5;
    }
    .table-title {
      background-color: #2c3e50;
      color: white;
      padding: 10px;
      font-weight: bold;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #ecf0f1;
    }
    .totals {
      text-align: right;
      margin-top: 10px;
    }
    .signature {
      margin-top: 40px;
      text-align: left;
    }
    .signature span {
      display: inline-block;
      margin-top: 60px;
      border-top: 1px solid #333;
      padding-top: 5px;
    }
    .no-print {
      text-align: center;
      margin: 20px 0;
    }
    .no-print button {
      padding: 10px 20px;
      margin: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    .footer {
      background: #2c3e50;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 14px;
    }
    .verify-section {
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
    }

    @media print {
      .no-print {
        display: none;
      }
      body {
        background: white;
        margin: 0;
      }
      .invoice {
        border: none;
      }
    }
  </style>
</head>
<body>

<div class="invoice">
  <div class="invoice-header">
    <div class="logo">MARS BANGLA</div>
    <div class="invoice-info">
      <h2>INVOICE</h2>
      <p>Invoice No: {{ $invoice->id }}</p>
      <p>Invoice Date: {{ $invoice->date ? (\Carbon\Carbon::parse($invoice->date)->format('d-m-Y')) : 'N/A' }}</p>
    </div>
  </div>

  <div class="address-section">
    <div class="address" style="text-align: left">
      <strong>Invoice To:</strong><br>
      {{ $invoice->factory->name }}<br>
      {{ $invoice->factory->email ?? '' }}<br>
      {{ $invoice->factory->phone ?? '' }}<br>
      {{ $invoice->factory->address ?? '' }}<br>
    </div>
    <div class="address" style="text-align: right">
      <strong>Invoice From:</strong><br>
      Mars Bangla<br>
      House #37, Road #07, Sector #03, Uttra<br>
      Dhaka, 1230
    </div>
  </div>

  <div class="table-title">Bill for CNG Supply</div>
  <table id="invoice-table">
    <thead>
      <tr>
        <th>SL</th>
        <th>Date</th>
        <th>
                        @if ($invoice->factory_type == 'dispansar')
                            Bill no
                        @elseif($invoice->factory_type == 'weightone')
                            Challan no
                        @elseif($invoice->factory_type == 'cngpump')
                            Bill no
                        @elseif($invoice->factory_type == 'weight')
                            Bill no
                        @endif
        </th>
        <th>Vehicle No</th>
        <th>
                        @if ($invoice->factory_type == 'dispansar')
                            Total Reading
                        @elseif($invoice->factory_type == 'weightone')
                            M3
                        @elseif($invoice->factory_type == 'cngpump')
                            M3
                        @elseif($invoice->factory_type == 'weight')
                            M3
                        @endif
        </th>
        <th>Rate</th>
        <th>Taka</th>
      </tr>
    </thead>
    <tbody id="invoice-body">

                        @if ($invoice->factory_type == 'dispansar')
                            @php
                            $items = $invoice->dispansar;
                            @endphp
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                            $items = $invoice->weightone;
                            @endphp
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                            $items = $invoice->cngpump;
                            @endphp
                        @elseif($invoice->factory_type == 'weight')
                            @php
                            $items = $invoice->weight;
                            @endphp
                        @endif

                        @php
                           $m3 = 0;
                           $total = 0;
                           @endphp


        @foreach ($items as $index => $item)
        
        
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->date ? (\Carbon\Carbon::parse($item->date)->format('d-m-Y')) : 'N/A' }}</td>
        <td>{{ $item->bill_no }}</td>
        <td>{{ $item->vehicle_reg_number }}</td>
                        @if ($invoice->factory_type == 'dispansar')
                           @php
                           $m3 += $item->total_reading;
                           @endphp
                            <td>{{ $item->total_reading }}</td>
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                           $m3 += $item->fm3;
                           @endphp
                            <td>{{ $item->fm3 }}</td>
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                           $m3 += $item->fm3;
                           @endphp
                            <td>{{ $item->fm3 }}</td>
                        @elseif($invoice->factory_type == 'weight')
                            @php
                           $m3 += $item->receive_m3;
                           @endphp
                            <td>{{ $item->receive_m3 }}</td>
                        @endif
        <td>{{ $item->rate }}</td>
                       @if ($invoice->factory_type == 'dispansar')

                           @php
                           $total += $item->bill_amount;
                           @endphp
                            <td>{{ $item->bill_amount }}</td>
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @elseif($invoice->factory_type == 'weight')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @endif
      </tr>
      @endforeach
      
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4"><strong>Total</strong></td>
        <td id="total-gas">{{ $m3 }}</td>
        <td></td>
        <td id="total-taka">{{ $total }}</td>
      </tr>
    </tfoot>
  </table>

  <div class="totals">
  
    <strong>In Words:</strong> <span id="taka-words">{{ ucwords(Illuminate\Support\Number::spell($total)) }} Only</span>
  </div>

  <div class="verify-section">
    <div id="qrcode"></div>
  </div>

  @if (request()->route()->getName() === 'backend.factory.invoice.export')
  <div class="signature">
    <span>Prepared By</span>
  </div>
  @endif
</div>

<div class="no-print">
  <button onclick="window.print()">Print</button>
</div>

<div class="footer">
  Email: marsbangla840@gmail.com | Mobile: 01923-660517, 01904-394972 | Address: House #37, Road #07, Sector #03, Uttra, Dhaka-1230
</div>

<script>

  function generateQRCode() {
    const invoiceId = "chjcnjdjncncjjd"; // Dynamically replace with real ID in production
    const verifyUrl = "{{ route('factory.invoice.verify', $invoice->hash) }}"; // Replace with actual route

    new QRCode(document.getElementById("qrcode"), {
      text: verifyUrl,
      width: 100,
      height: 100
    });
  }
  generateQRCode();
</script>

</body>
</html>
