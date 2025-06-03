@extends('boilerplate::layout.index', [
    'title' => 'Cng Pump & Weight Scale Details',
    'subtitle' => 'Show Cng Pump & Weight Scale',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3 no-print no-export">
        <a href="{{ route('backend.factory.weightone.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Cng Pump & Weight Scale Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $weightone->date ? (\Carbon\Carbon::parse($weightone->date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Car No</th><td>{{ $weightone->vehicle_reg_number }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $weightone->pumpname->name }}</td></tr>
                    <tr><th>Factory</th><td>{{ $weightone->factory->name }}</td></tr>
                    <tr><th>M3</th><td>{{ $weightone->cng_purchase_m3 }}</td></tr>
                    <tr><th>Purchase Rate</th><td>{{ $weightone->lrate }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $weightone->purchase_taka }}</td></tr>
                    <tr><th>Challan No</th><td>{{ $weightone->bill_no }}</td></tr>
                    <tr><th>Challan Date</th><td>{{ $weightone->bill_date }}</td></tr>
                    <tr><th>First Weight</th><td>{{ $weightone->first_weight }}</td></tr>
                    <tr><th>Second Weight</th><td>{{ $weightone->second_weight }}</td></tr>
                    <tr><th>FM3</th><td>{{ $weightone->fm3 }}</td></tr>
                    <tr><th>Rate</th><td>{{ $weightone->rate }}</td></tr>
                    <tr><th>FTK</th><td>{{ $weightone->ftk }}</td></tr>
                    <tr hidden><th>Bill Amount</th><td>{{ $weightone->bill_amount }}</td></tr>
                    <tr><th>Cash Receipt Date</th><td>{{ $weightone->cash_receipt_date ? (\Carbon\Carbon::parse($weightone->cash_receipt_date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Cash Receipt Amount</th><td>{{ $weightone->cash_receipt_amount }}</td></tr>
                    <tr><th>Received By</th><td>{{ $weightone->recived_by }}</td></tr>
                    <tr><th>Remarks</th><td>{{ $weightone->remarks }}</td></tr>
                </tbody>
            </table>
            <div class="mt-3 no-print no-export">
                <button id="exportPdf" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button id="exportPrint" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
            </div>
        </x-boilerplate::card>
    </div>
</div>
@endsection

@push('css')
<style>
@media print {
    .no-print { display: none !important; }
}
</style>
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function hideExportButtons(hide = true) {
    document.querySelectorAll('.no-print, .no-export').forEach(function(el) {
        el.style.display = hide ? 'none' : '';
    });
}
document.getElementById('exportPdf').addEventListener('click', function() {
    hideExportButtons(true);
    html2canvas(document.querySelector('.card')).then(function(canvas) {
        var imgData = canvas.toDataURL('image/png');
        var pdf = new jspdf.jsPDF('p', 'mm', 'a4');
        var pageWidth = pdf.internal.pageSize.getWidth();
        var pageHeight = pdf.internal.pageSize.getHeight();
        var imgWidth = pageWidth - 20;
        var imgHeight = canvas.height * imgWidth / canvas.width;
        var y = 10;
        if(imgHeight > pageHeight - 20) imgHeight = pageHeight - 20;
        pdf.addImage(imgData, 'PNG', 10, y, imgWidth, imgHeight);
        pdf.save('weightone-details.pdf');
        hideExportButtons(false);
    });
});
document.getElementById('exportPrint').addEventListener('click', function() {
    hideExportButtons(true);
    window.print();
    hideExportButtons(false);
});
</script>
@endpush
