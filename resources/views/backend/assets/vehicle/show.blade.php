@extends('boilerplate::layout.index', [
    'title' => 'Vehicle',
    'subtitle' => 'View Vehicle',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.asset.vehicle.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Vehicle Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Vehicle Number</th><td>{{ $vehicle->vehicle_number }}</td></tr>
                    <tr><th>Vehicle Type</th><td>{{ $vehicle->vehicle_type }}</td></tr>
                    <tr><th>Driver Name</th><td>{{ $vehicle->driver_name }}</td></tr>
                    <tr><th>Driver Phone</th><td>{{ $vehicle->driver_phone }}</td></tr>
                    <tr><th>Registration Date</th><td>{{ $vehicle->registration_date ? (\Carbon\Carbon::parse($vehicle->registration_date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Status</th><td>{!! $vehicle->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td></tr>
                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
