@extends('boilerplate::layout.index', [
    'title' => 'Cng Pump & Weight Scale Details',
    'subtitle' => 'Show Cng Pump & Weight Scale',
])

@section('content')
<x-boilerplate::card>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.factory.weightone.index') }}" class="btn btn-default" data-toggle="tooltip" title="Cng Pump & Weight Scale lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    
                    <tr><th>Challan No</th><td>{{ $weightone->bill_no }}</td></tr>
                    <tr><th>Challan Date</th><td>{{ $weightone->bill_date }}</td></tr>
                    <tr><th>First Weight</th><td>{{ $weightone->first_weight }}</td></tr>
                    <tr><th>Second Weight</th><td>{{ $weightone->second_weight }}</td></tr>
                    <tr><th>FM3</th><td>{{ $weightone->fm3 }}</td></tr>
                    <tr><th>Rate</th><td>{{ $weightone->rate }}</td></tr>
                    <tr><th>FTK</th><td>{{ $weightone->ftk }}</td></tr>
                    <tr><th>Bill Amount</th><td>{{ $weightone->bill_amount }}</td></tr>
                    <tr><th>Cash Receipt Date</th><td>{{ $weightone->cash_receipt_date }}</td></tr>
                    <tr><th>Cash Receipt Amount</th><td>{{ $weightone->cash_receipt_amount }}</td></tr>
                    <tr><th>Received By</th><td>{{ $weightone->recived_by }}</td></tr>
                    <tr><th>Remarks</th><td>{{ $weightone->remarks }}</td></tr>
                    <tr><th>Date</th><td>{{ $weightone->date }}</td></tr>
                    <tr><th>Car No</th><td>{{ $weightone->vehicle_reg_number }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $weightone->pump_name }}</td></tr>
                    <tr><th>M3</th><td>{{ $weightone->cng_purchase_m3 }}</td></tr>
                    <tr><th>Purchase Rate</th><td>{{ $weightone->lrate }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $weightone->purchase_taka }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</x-boilerplate::card>
@endsection
