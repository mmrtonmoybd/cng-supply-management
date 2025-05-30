<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    :root {
      --primary: #222;
      --secondary: #444;
      --bg: #fff;
      --card-bg: #fff;
      --border: #e5e5e5;
      --text: #222;
      --muted: #888;
    }
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f7f7f7;
      color: var(--text);
      margin: 0;
      padding: 0;
      font-size: 18px;
    }
    .invoice {
      max-width: 900px;
      margin: 0 auto;
      background: var(--card-bg);
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(34,34,34,0.04);
      padding: 16px 24px 16px 24px;
      border: 1px solid var(--border);
      position: relative;
      font-size: 1.15rem;
    }
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1.5px solid var(--border);
      padding-bottom: 8px;
      margin-bottom: 16px;
      margin-top: 0;
      padding-top: 0;
      font-size: 1.25rem;
    }
    .logo {
      display: flex;
      align-items: center;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      letter-spacing: 1px;
    }
    .logo img {
      height: 40px;
      margin-right: 10px;
    }
    .invoice-info {
      text-align: right;
      font-size: 1.1rem;
    }
    .invoice-info h2 {
      margin: 0 0 4px 0;
      color: var(--primary);
      font-size: 1.7rem;
      letter-spacing: 0.5px;
    }
    .address-section {
      display: flex;
      justify-content: space-between;
      margin: 16px 0 10px 0;
      gap: 16px;
      font-size: 1.08rem;
    }
    .address {
      width: 48%;
      line-height: 1.6;
      background: #fafbfc;
      border-radius: 4px;
      padding: 10px 14px;
      border: 1px solid var(--border);
      font-size: 1.08rem;
    }
    .table-title {
      background: #f2f2f2;
      color: var(--primary);
      padding: 10px;
      font-weight: 600;
      text-align: center;
      border-radius: 4px 4px 0 0;
      font-size: 1.15rem;
      letter-spacing: 0.5px;
      margin-bottom: 0;
      border: 1px solid var(--border);
      border-bottom: none;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
      background: #fff;
      border-radius: 0 0 4px 4px;
      overflow: hidden;
      box-shadow: none;
      border: 1px solid var(--border);
      font-size: 1.08rem;
    }
    th, td {
      border: 1px solid var(--border);
      padding: 10px 6px;
      text-align: center;
      font-size: 1.08rem;
    }
    th {
      background: #f7f7f7;
      color: var(--primary);
      font-weight: 600;
      letter-spacing: 0.2px;
      font-size: 1.12rem;
    }
    tfoot td {
      font-weight: 700;
      background: #f2f2f2;
      color: var(--primary);
      font-size: 1.15rem;
    }
    .totals {
      text-align: right;
      margin-top: 8px;
      font-size: 1.13rem;
      color: var(--primary);
      font-weight: 600;
    }
    .signature {
      margin-top: 24px;
      text-align: left;
      font-size: 1.08rem;
    }
    .signature span {
      display: inline-block;
      margin-top: 30px;
      border-top: 1.5px solid var(--border);
      padding-top: 5px;
      color: var(--muted);
      font-size: 1.08rem;
      letter-spacing: 0.5px;
    }
    .no-print {
      text-align: center;
      margin: 16px 0 0 0;
      font-size: 1.08rem;
    }
    .no-print button {
      padding: 10px 22px;
      margin: 5px;
      font-size: 1.08rem;
      cursor: pointer;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 4px;
      transition: background 0.2s;
      font-weight: 600;
      box-shadow: 0 1px 4px rgba(34,34,34,0.06);
    }
    .no-print button:hover {
      background: var(--secondary);
    }
    .footer {
      background: #f2f2f2;
      color: var(--muted);
      padding: 12px;
      text-align: center;
      font-size: 1.08rem;
      border-radius: 0 0 6px 6px;
      margin-top: 16px;
      letter-spacing: 0.5px;
      border: 1px solid var(--border);
      border-top: none;
    }
    .verify-section {
      display: flex;
      justify-content: flex-end;
      margin-top: 12px;
      font-size: 1.08rem;
    }
    #qrcode {
      background: #fff;
      padding: 4px;
      border-radius: 4px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.03);
      border: 1px solid var(--border);
    }
    @media print {
      html, body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
      }
      .invoice {
        border: none;
        box-shadow: none;
        margin: 0 !important;
        padding: 8px 8px 8px 8px !important;
        page-break-inside: avoid;
      }
      .invoice-header {
        margin-top: 0 !important;
        padding-top: 0 !important;
        margin-bottom: 8px !important;
        padding-bottom: 4px !important;
      }
      .address-section {
        margin: 8px 0 6px 0 !important;
        gap: 8px !important;
      }
      .footer {
        border-radius: 0;
        border: none;
        margin-top: 8px !important;
        padding: 6px !important;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="invoice">
  <div class="invoice-header">
    <div class="logo">
        <img src="{{ asset('logo/new-logo.png') }}">MARS BANGLA</div>
    <div class="invoice-info">
      <h2>INVOICE</h2>
      <strong><p>Invoice No: #{{ $invoice->id }}</p>
      <p>Invoice Date: {{ $invoice->date ? (\Carbon\Carbon::parse($invoice->date)->format('d-m-Y')) : 'N/A' }}</p>
    </strong>
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
    <span><strong>Prepared By</strong></span>
  </div>
  @endif
</div>

<div class="no-print">
  <button onclick="window.print()">Print</button>
  <button onclick="downloadPDF()" style="margin-left:10px;background:var(--accent);color:#fff;">Download PDF</button>
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

  function downloadPDF() {
  const invoice = document.querySelector('.invoice');
  html2canvas(invoice, { scale: 2, useCORS: true }).then(canvas => {
    const imgData = canvas.toDataURL('image/png');
    const pdf = new window.jspdf.jsPDF('p', 'pt', 'a4');
    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();
    const imgWidth = pageWidth - 40;
    const imgHeight = canvas.height * imgWidth / canvas.width;
    let position = 20;
    pdf.addImage(imgData, 'PNG', 20, position, imgWidth, imgHeight);
    pdf.save('invoice-{{ $invoice->id }}.pdf');
  });
}
</script>

</body>
</html>
