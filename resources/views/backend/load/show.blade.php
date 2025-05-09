@extends('boilerplate::layout.index', [
    'title' => 'Load Entry Details',
    'subtitle' => 'View Load Entry',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.load.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Load Entry Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $loadEntry->date }}</td></tr>
                    <tr><th>Car No</th><td>{{ $loadEntry->vehicle_reg_number }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $loadEntry->pump_name }}</td></tr>
                    <tr><th>M3</th><td>{{ $loadEntry->cng_purchase_m3 }}</td></tr>
                    <tr><th>Rate</th><td>{{ $loadEntry->rate }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $loadEntry->purchase_taka }}</td></tr>
                    <tr><th>Fuel Cost</th><td>{{ $loadEntry->fuel_cost }}</td></tr>
                    <tr><th>Fuel Pump</th><td>{{ $loadEntry->fuel_pump }}</td></tr>
                    <tr><th>Diesel Litre</th><td>{{ $loadEntry->diesel_litter }}</td></tr>
                    <tr><th>Diesel Rate</th><td>{{ $loadEntry->diesel_rate }}</td></tr>
                    <tr><th>Factory Name</th><td>{{ $loadEntry->factory_name }}</td></tr>
                    <tr><th>Status</th><td>{{ ucfirst($loadEntry->status) }}</td></tr>
                    <tr><th>Remark</th><td>{{ $loadEntry->remark }}</td></tr>
                    <tr><th>Created At</th><td>{{ $loadEntry->created_at }}</td></tr>
                    <tr><th>Updated At</th><td>{{ $loadEntry->updated_at }}</td></tr>
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
                    pdf.save('load-entry.pdf');
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
