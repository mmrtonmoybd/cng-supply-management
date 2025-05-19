@extends('boilerplate::layout.index', [
    'title' => 'Weight Scale Details',
    'subtitle' => 'Show Weight Scale',
])

@section('content')
<x-boilerplate::card>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.weight.index') }}" class="btn btn-default" data-toggle="tooltip" title="Weight Scale lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr><th>Date</th><td>{{ $weight->date }}</td></tr>
                    <tr><th>Car No</th><td>{{ $weight->vehicle_reg_number }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $weight->pump_name }}</td></tr>
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
        </div>
    </div>
</x-boilerplate::card>
@endsection
