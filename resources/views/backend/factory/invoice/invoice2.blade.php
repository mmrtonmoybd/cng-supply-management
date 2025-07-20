<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    :root {
      --primary: #1a237e;
      --secondary: #283593;
      --bg: #fff;
      --card-bg: #fff;
      --border: #e0e0e0;
      --text: #2c3e50;
      --muted: #707070;
      --accent: #f44336;
    }
    body {
      font-family: 'Roboto', 'Segoe UI', Arial, sans-serif;
      background: #f7f7f7;
      color: var(--text);
      margin: 0;
      padding: 0;
      font-size: 18px;
    }
    .invoice {
      max-width: 900px;
      margin: 2rem auto;
      background: var(--card-bg);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 32px 40px;
      border: 1px solid var(--border);
      position: relative;
      font-size: 1.15rem;
    }
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid var(--border);
      padding-bottom: 20px;
      margin-bottom: 24px;
      margin-top: 0;
      padding-top: 0;
      font-size: 1.25rem;
    }
    .logo {
      display: flex;
      align-items: flex-start;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      letter-spacing: 1px;
    }
    .logo img {
      height: 50px;
      margin-right: 15px;
      object-fit: contain;
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
      margin: 28px 0 32px 0;
      gap: 40px;
      font-size: 1.08rem;
    }
    .address {
      width: 48%;
      line-height: 1.8;
      background: #f8fafc;
      border-radius: 6px;
      padding: 20px 24px;
      border: 1px solid var(--border);
      font-size: 1.08rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .table-title {
      background: var(--primary);
      color: white;
      padding: 12px 16px;
      font-weight: 600;
      text-align: center;
      border-radius: 6px 6px 0 0;
      font-size: 1.2rem;
      letter-spacing: 0.5px;
      margin-bottom: 0;
    }
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 24px;
      background: #fff;
      border-radius: 0 0 6px 6px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      font-size: 1.08rem;
    }
    th, td {
      border: 1px solid var(--border);
      padding: 12px 16px;
      text-align: center;
      font-size: 1.08rem;
    }
    th {
      background: var(--secondary);
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
      font-size: 1.12rem;
      border-color: rgba(255,255,255,0.1);
    }
    tfoot td {
      font-weight: 700;
      background: #f8fafc;
      color: var(--primary);
      font-size: 1.2rem;
      border-top: 2px solid var(--border);
    }
    .totals {
      text-align: right;
      margin: 24px 0;
      padding: 20px;
      font-size: 1.2rem;
      color: var(--primary);
      font-weight: 600;
      background: #f8fafc;
      border-radius: 6px;
      border: 1px solid var(--border);
    }
    .signature {
      margin-top: 100px;
      margin-bottom: 20px;
      text-align: left;
      font-size: 1.1rem;
      position: relative;
    }
    .signature span {
      display: inline-block;
      min-width: 200px;
      margin-top: 40px;
      border-top: 2px solid var(--border);
      padding-top: 8px;
      color: var(--primary);
      font-size: 1.1rem;
      letter-spacing: 0.5px;
      position: relative;
    }
    .signature span::after {
      content: '';
      position: absolute;
      top: -2px;
      left: 0;
      width: 50px;
      height: 2px;
      background: var(--primary);
    }
    .no-print {
      text-align: center;
      margin: 32px 0;
      font-size: 1.1rem;
    }
    .no-print button {
      padding: 12px 28px;
      margin: 8px;
      font-size: 1.1rem;
      cursor: pointer;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .no-print button:hover {
      background: var(--secondary);
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .no-print button:nth-child(2) {
      background: var(--accent);
    }
    .no-print button:nth-child(2):hover {
      background: #d32f2f;
    }
    .no-print button i {
      margin-right: 8px;
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
      margin: 32px 0;
      font-size: 1.08rem;
      position: relative;
    }
    #qrcode {
      background: #fff;
      padding: 8px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      border: 1px solid var(--border);
    }
    #qrcode::before {
      content: 'Scan to Verify';
      position: absolute;
      bottom: -25px;
      right: 0;
      font-size: 0.9rem;
      color: var(--muted);
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
        <div style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('logo/new-logo.png') }}">
                <font color='red' style="font-size: 1.8rem; margin-left: 10px;">MARS BANGLA</font>
            </div>
            <div style="font-size: 0.85rem; color: #555; margin-top: 8px; line-height: 1.4;">
                <div><i class="fas fa-envelope"></i> Email: marsbangla840@gmail.com</div>
                <div><i class="fas fa-phone"></i> Mobile: 01923-660517, 01904-394972</div>
                <div><i class="fas fa-map-marker-alt"></i> Address: House #43, Road #03, Sector #03, Uttra, Dhaka-1230</div>
            </div>
        </div>
    </div>
    <div class="invoice-info">
      <h2>INVOICE</h2>
      <strong><p>Invoice No: #{{ $invoice->invoice_number }}</p>
      <p>Invoice Date: {{ $invoice->date ? (\Carbon\Carbon::parse($invoice->date)->format('l, F j, Y')) : 'N/A' }}</p>
    </strong>
    </div>
  </div>

  <div class="address-section">
    <div class="address" style="text-align: left">
      <strong>Invoice To:</strong><br>
      {{ $invoice->factory?->name }}<br>
      {{ $invoice->factory?->address ?? '' }}<br>
      {{ $invoice->factory?->email ?? '' }}<br>
    </div>
    <div class="address" style="text-align: right">
      <strong>Invoice From:</strong><br>
      Mars Bangla<br>
      House #43, Road #03, Sector #03, Uttra<br>
      Dhaka, 1230<br>
      Hotline: 01904-394972, 01923-660517<br>
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
  
    <strong>In Words:</strong> <span id="taka-words">{{ Illuminate\Support\Number::spell($total) }} only</span>
  </div>

  @if (request()->route()->getName() === 'backend.factory.invoice.export')
  <div class="signature">
    <span><strong>Prepared By</strong></span>
  </div>
  @endif
</div>

<div class="no-print">
  <button onclick="window.print()"><i class="fas fa-print"></i>Print</button>
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
