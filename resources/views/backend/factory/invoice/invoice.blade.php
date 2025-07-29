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
      {{ $invoice->factory?->name }}<br>
      {{ $invoice->factory?->address ?? '' }}<br>
      {{ $invoice->factory?->email ?? '' }}
    </div>
    <div class="right">
      <strong>Invoice no:</strong> #{{ $invoice->invoice_number }}<br>
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
                            $items = $invoice->dispansar->sortBy('bill_no');
                            @endphp
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                            $items = $invoice->weightone->sortBy('bill_no');
                            @endphp
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                            $items = $invoice->cngpump->sortBy('bill_no');
                            @endphp
                        @elseif($invoice->factory_type == 'weight')
                            @php
                            $items = $invoice->weight->sortBy('bill_no');
                            @endphp
                        @endif

                        @php
                           $m3 = 0;
                           $total = 0;
                           @endphp


        @foreach ($items as $index => $item)
		
		
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->bill_date ? (\Carbon\Carbon::parse($item->bill_date)->format('d-m-Y')) : (\Carbon\Carbon::parse($item->date)->format('d-m-Y')) }}</td>
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
  @php
function convertNumberToWordsIndian($number) {
    $number = floor($number); // Remove decimal

    $words = array(
        '0' => '', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five',
        '6' => 'Six', '7' => 'Seven', '8' => 'Eight',
        '9' => 'Nine', '10' => 'Ten', '11' => 'Eleven',
        '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy', '80' => 'Eighty',
        '90' => 'Ninety'
    );

    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    $result = '';

    $i = 0;
    $str = array();
    $numberStr = (string) $number;

    while ($number > 0) {
        if ($i == 0) {
            $divider = 100;
        } elseif ($i == 1) {
            $divider = 10;
        } else {
            $divider = 100;
        }

        $numberPart = $number % $divider;
        $number = floor($number / $divider);

        if ($numberPart) {
            $strPart = '';
            if ($numberPart < 21) {
                $strPart = $words[$numberPart];
            } else {
                $tens = floor($numberPart / 10) * 10;
                $units = $numberPart % 10;
                $strPart = $words[$tens] . ' ' . $words[$units];
            }

            if ($i != 0 && $strPart != '') {
                $strPart .= ' ' . $digits[$i];
            }

            array_unshift($str, $strPart);
        }

        $i++;
    }

    return implode(' ', $str);
}
@endphp
    <strong >In Words: <span >{{ convertNumberToWordsIndian($total) }} only</span></strong>
  </div>

  <!-- Spacer before footer -->
  <div class="spacer"></div>

  <!-- Footer Signature -->
  <div class="print-footer">
    <p><strong><u>Prepared By:</u></strong></p>
  </div>

</body>
</html>
