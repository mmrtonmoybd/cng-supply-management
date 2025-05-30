@extends('boilerplate::layout.index', [
    'title' => 'Pump Details',
    'subtitle' => 'View Pump',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.pump.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $pump->date ? (\Carbon\Carbon::parse($pump->date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Vehicle Registration Number</th><td>{{ $pump->vehicle_reg_number ?? 'N/A' }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $pump->pumpname->name ?? 'N/A' }}</td></tr>
                    <tr><th>Pump type</th><td>{!! (!$pump->load_entry_id) ? '<span class="badge badge-pill badge-primary">Third party</span>' : '<span class="badge badge-pill badge-warning">Main</span>' !!}</td></tr>
                    <tr><th>CNG Purchase (m3)</th><td>{{ $pump->cng_purchase_m3 ?? 'N/A' }}</td></tr>
                    <tr><th>Rate</th><td>{{ $pump->rate ?? 'N/A' }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $pump->purchase_taka ?? 'N/A' }}</td></tr>
                    <tr><th>Factory Name</th><td>{{ $pump->factory->name ?? 'N/A' }}</td></tr>
                    <tr><th>Payment Date</th><td>{{ $pump->payment_date ? (\Carbon\Carbon::parse($pump->payment_date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Payment</th><td>{{ $pump->payment }}</td></tr>
                    <tr><th>Balance</th><td>{{ $pump->balance }}</td></tr>
                    <tr><th>Remarks</th><td>{{ $pump->remarks }}</td></tr>
                </tbody>
            </table>
        </x-boilerplate::card>
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-secondary" onclick="printCard()">
                <i class="fa fa-print"></i> Print
            </button>
            <button class="btn btn-danger" id="pdfBtn">
                <i class="fa fa-file-pdf"></i> PDF
            </button>
            <button class="btn btn-info" id="copyBtn">
                <i class="fa fa-copy"></i> Copy
            </button>
        </div>
        @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
            function printCard() {
                var printContents = document.querySelector('.card').outerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                window.location.reload();
            }
            document.getElementById('copyBtn').onclick = function() {
                let table = document.querySelector('table');
                let range = document.createRange();
                range.selectNode(table);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                try {
                    document.execCommand('copy');
                    window.getSelection().removeAllRanges();
                    alert('Table copied to clipboard!');
                } catch (err) {
                    alert('Failed to copy!');
                }
            };
            document.getElementById('pdfBtn').onclick = function() {
                var card = document.querySelector('.card');
                // Save original styles
                var originalBg = card.style.backgroundColor;
                var table = card.querySelector('table');
                var originalTableBg = table.style.backgroundColor;
                var originalThBg = [];
                var originalTdBg = [];
                table.querySelectorAll('th').forEach(function(th, i) {
                    originalThBg[i] = th.style.backgroundColor;
                    th.style.backgroundColor = '#fff';
                });
                table.querySelectorAll('td').forEach(function(td, i) {
                    originalTdBg[i] = td.style.backgroundColor;
                    td.style.backgroundColor = '#fff';
                });
                card.style.backgroundColor = '#fff';
                table.style.backgroundColor = '#fff';
                // Remove table-striped effect
                table.classList.remove('table-striped');
                html2canvas(card, {backgroundColor: '#fff'}).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');
                    var pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
                    var pageWidth = pdf.internal.pageSize.getWidth();
                    var pageHeight = pdf.internal.pageSize.getHeight();
                    var imgWidth = pageWidth - 20;
                    var imgHeight = canvas.height * imgWidth / canvas.width;
                    var y = 10;
                    if(imgHeight > pageHeight - 20) imgHeight = pageHeight - 20;
                    pdf.addImage(imgData, 'PNG', 10, y, imgWidth, imgHeight);
                    pdf.save('pump-details.pdf');
                    // Restore original styles
                    card.style.backgroundColor = originalBg;
                    table.style.backgroundColor = originalTableBg;
                    table.classList.add('table-striped');
                    table.querySelectorAll('th').forEach(function(th, i) {
                        th.style.backgroundColor = originalThBg[i];
                    });
                    table.querySelectorAll('td').forEach(function(td, i) {
                        td.style.backgroundColor = originalTdBg[i];
                    });
                });
            };
        </script>
        @endpush
    </div>
</div>
@endsection
