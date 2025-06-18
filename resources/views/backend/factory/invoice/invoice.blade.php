<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice Print</title>
  <style>
    body {
      margin: 0;
      padding: 20px;
      font-family: Arial, sans-serif;
    }

    .invoice-info {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .invoice-info .left,
    .invoice-info .right {
      display: inline-block;
      vertical-align: top;
      width: 48%;
    }

    .invoice-info .right {
      text-align: right;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      page-break-inside: auto;
    }

    thead {
      display: table-header-group;
    }

    tbody tr {
      page-break-inside: avoid !important;
	  break-inside: avoid-row !important;
    }

    table, th, td {
      border: 1px solid #000;
    }

    th, td {
      padding: 8px;
      text-align: center;
      font-size: 14px;
    }

    .spacer {
      height: 100px;
    }

    .print-footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 80px 0px 0px 0px;
      text-align: left;
      border-top: 1px solid #000;
      font-size: 14px;
      background: #fff;
    }

    .print-button {
      margin: 20px;
      text-align: center;
    }

    .print-button button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    @media print {
      .print-button {
        display: none;
      }

      @page {
        margin: 1.95in 0in 0.7in 0.5in;
      }

      .spacer {
        height: 100px;
      }
	  
	    thead {
    display: table-header-group; /* Ensures table headers repeat */
  }

  tfoot {
    display: table-footer-group; /* Optional: adds footer if needed */
  }

  tr, td, th {
    page-break-inside: avoid !important;
    break-inside: avoid !important;
  }

    }
  </style>
</head>
<body>

  <!-- Print Button -->
  <div class="print-button">
    <button onclick="window.print()">🖨️ Print</button>
  </div>

  <!-- Invoice Info -->
  <div class="invoice-info">
    <div class="left">
      <strong>Invoice To:</strong><br>
      {{ $invoice->factory->name }}<br>
      {{ $invoice->factory->address ?? '' }}<br>
      {{ $invoice->factory->email ?? '' }}
    </div>
    <div class="right">
      <strong>Invoice ID:</strong> #{{ $invoice->id }}<br>
      <strong>Invoice Date:</strong> {{ $invoice->date ? (\Carbon\Carbon::parse($invoice->date)->format('l, F j, Y')) : 'N/A' }}
    </div>
  </div>

  <!-- Table -->
  <div style="text-align: center; font-family: sans-serif; font-size: 16pt; margin-bottom: 20px;">
  <u>Bill for CNG Supply</u>
</div>
  <table>
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
    <tbody>
	
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
	  
	  <tr>
        <td colspan="4"><strong>Total</strong></td>
        <td id="total-gas">{{ $m3 }}</td>
        <td></td>
        <td id="total-taka">{{ $total }}</td>
      </tr>
	  
    </tbody>
  </table>
  <div>
  <br>
    <strong >In Words: <span >{{ Illuminate\Support\Number::spell($total) }} only</span></strong>
  </div>

  <!-- Spacer before footer -->
  <div class="spacer"></div>

  <!-- Footer Signature -->
  <div class="print-footer">
    <p><strong><u>Prepared By:</u></strong></p>
  </div>

</body>
</html>
