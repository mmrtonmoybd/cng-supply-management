@extends('boilerplate::layout.index', [
    'title' => 'Vehicle Income Details',
    'subtitle' => 'View Vehicle Income',
])

@section('content')
<div class="row justify-content-between mb-3">
    <div class="col-auto">
        <a href="{{ route('backend.vehicleIncome.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Vehicle Income Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $vehicleincome->date ? (\Carbon\Carbon::parse($vehicleincome->date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Car No</th><td>{{ $vehicleincome->vehicle_reg_number ?? 'N/A' }}</td></tr>
                    <tr><th>Pump Name</th><td>{{ $vehicleincome->pumpname->name }}</td></tr>
                    <tr><th>Factory Name</th><td>{{ $vehicleincome->factory->name }}</td></tr>
                    <tr><th>Rent</th><td>{{ $vehicleincome->rent }}</td></tr>
                    <tr><th>M3</th><td>{{ $vehicleincome->cng_purchase_m3 }}</td></tr>
                    <tr><th>Load rate</th><td>{{ $vehicleincome->lrate }}</td></tr>
                    <tr><th>Purchase Taka</th><td>{{ $vehicleincome->purchase_taka }}</td></tr>
                    <tr><th>F date</th><td>{{ $vehicleincome->bill_date }}</td></tr>
                    <tr><th>Fm3</th><td>{{ $vehicleincome->fm3 }}</td></tr>
                    <tr><th>Rate</th><td>{{ $vehicleincome->rate }}</td></tr>
                    <tr><th>Ftk</th><td>{{ $vehicleincome->ftk }}</td></tr>
                    <tr><th>Difference</th><td>{{ $vehicleincome->difference }}</td></tr>
                    <tr><th>Rent</th><td>{{ $vehicleincome->rent }}</td></tr>
                    <tr><th>Driver Fooding</th><td>{{ $vehicleincome->driver_fooding }}</td></tr>
                    <tr><th>Maintenance</th><td>{{ $vehicleincome->maintenance }}</td></tr>
                    <tr><th>Other</th><td>{{ $vehicleincome->other }}</td></tr>
                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
