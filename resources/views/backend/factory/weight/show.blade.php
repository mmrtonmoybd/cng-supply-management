@extends('boilerplate::layout.index', [
    'title' => 'Weight Scale Details',
    'subtitle' => 'Show Weight Scale',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3 no-print no-export">
        <a href="{{ route('backend.factory.weight.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Weight Scale Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $weight->date }}</td></tr>
                    <tr><th>Car No</th><td>{{ $weight->vehicle_reg_number }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $weight->pumpname->name }}</td></tr>
                    <tr><th>Factory</th><td>{{ $weight->factory->name }}</td></tr>
                    <tr><th>M3</th><td>{{ $weight->cng_purchase_m3 }}</td></tr>
                    <tr><th>Rate (Load)</th><td>{{ $weight->lrate }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $weight->purchase_taka }}</td></tr>
                    <tr><th>Bill No</th><td>{{ $weight->bill_no }}</td></tr>
                    <tr><th>Bill Date</th><td>{{ $weight->bill_date }}</td></tr>
                    <tr><th>First Weight</th><td>{{ $weight->first_weight }}</td></tr>
                    <tr><th>Second Weight</th><td>{{ $weight->second_weight }}</td></tr>
                    <tr><th>Total Weight</th><td>{{ $weight->total_weight }}</td></tr>
                    <tr><th>Fact</th><td>{{ $weight->fact }}</td></tr>
                    <tr><th>Receive M3</th><td>{{ $weight->receive_m3 }}</td></tr>
                    <tr><th>Rate</th><td>{{ $weight->rate }}</td></tr>
                    <tr><th>Factory TK</th><td>{{ $weight->ftk }}</td></tr>
                    <tr><th>Total Bill No</th><td>{{ $weight->total_bill_no }}</td></tr>
                    <tr><th>Total Bill Taka</th><td>{{ $weight->total_bill_taka }}</td></tr>
                    <tr><th>Difference Taka</th><td>{{ $weight->difference_taka }}</td></tr>
                    <tr><th>Difference M3</th><td>{{ $weight->difference_m3 }}</td></tr>
                    <tr><th>In</th><td>{{ $weight->in }}</td></tr>
                    <tr><th>Out</th><td>{{ $weight->out }}</td></tr>
                    <tr><th>Bill Amount</th><td>{{ $weight->bill_amount }}</td></tr>
                    <tr><th>Cash Receipt Date</th><td>{{ $weight->cash_receipt_date }}</td></tr>
                    <tr><th>Cash Receipt Amount</th><td>{{ $weight->cash_receipt_amount }}</td></tr>
                    <tr><th>Received By</th><td>{{ $weight->recived_by }}</td></tr>
                    <tr><th>Remarks</th><td>{{ $weight->remarks }}</td></tr>
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
        pdf.save('weight-details.pdf');
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
