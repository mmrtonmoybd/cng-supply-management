@extends('boilerplate::layout.index', [
    'title' => 'Transport Details',
    'subtitle' => 'View Transport',
])

@section('content')
<div class="row justify-content-between mb-3">
    <div class="col-auto">
        <a href="{{ route('backend.transport.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
    <div class="col-auto">
        <a href="{{ route('backend.transport.export', $transport->id) }}" class="btn btn-info" target="_blank" data-toggle="tooltip" title="Export/Print">
            <i class="fas fa-print"></i> Export/Print
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Transport Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Date</th><td>{{ $transport->date ? (\Carbon\Carbon::parse($transport->date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Vehicle</th><td>{{ $transport->vehicle->vehicle_number ?? 'N/A' }}</td></tr>
                    <tr><th>From</th><td>{{ $transport->from }}</td></tr>
                    <tr><th>To</th><td>{{ $transport->to }}</td></tr>
                    <tr><th>Rent Income</th><td>{{ $transport->rent }}</td></tr>
                    <tr><th>Maintenance Cost</th><td>{{ $transport->maintenance_cost }}</td></tr>
                    <tr><th>Diesel Cost</th><td>{{ $transport->diesel_cost }}</td></tr>
                    <tr><th>Toll Cost</th><td>{{ $transport->toll_cost }}</td></tr>
                    <tr><th>Labour Cost</th><td>{{ $transport->labour_cost }}</td></tr>
                    <tr><th>Chada Cost</th><td>{{ $transport->chada_cost }}</td></tr>
                    <tr><th>Fooding Cost</th><td>{{ $transport->fooding_cost }}</td></tr>
                    <tr><th>Police Cost</th><td>{{ $transport->police_cost }}</td></tr>
                    <tr><th>Parking Cost</th><td>{{ $transport->parking_cost }}</td></tr>
                    <tr><th>Other Cost</th><td>{{ $transport->other_cost }}</td></tr>
                    <tr><th>Total Cost</th><td>{{ $transport->total_cost }}</td></tr>
                    <tr><th>Net Income</th><td>{{ $transport->rent - $transport->total_cost }}</td></tr>
                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
