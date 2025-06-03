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
                    <tr><th>Maintenance Date</th><td>
                        @php
                            $maintenanceClass = '';
                            $maintenanceHuman = '';
                            if ($vehicle->maintenance_date) {
                                $maintenance = \Carbon\Carbon::parse($vehicle->maintenance_date);
                                $now = \Carbon\Carbon::now();
                                $diffInDays = $now->diffInDays($maintenance, false);
                                $maintenanceHuman = '('.$maintenance->diffForHumans($now).')';
                                if ($maintenance < $now || $diffInDays <= 7) {
                                    $maintenanceClass = 'text-danger';
                                } elseif ($diffInDays <= 20) {
                                    $maintenanceClass = 'text-warning';
                                } else {
                                    $maintenanceClass = 'text-success';
                                }
                            }
                        @endphp
                        @if($vehicle->maintenance_date)
                            <span class="{{ $maintenanceClass }}">{{ \Carbon\Carbon::parse($vehicle->maintenance_date)->format('d-m-Y') }}</span>
                            <span class="text-muted">{{ $maintenanceHuman }}</span>
                        @else
                            N/A
                        @endif
                    </td></tr>
                    <tr><th>Status</th><td>{!! $vehicle->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td></tr>
                    <tr>
                        <th colspan="2">
                            <h4 class="mb-3 mt-4">Vehicle Documents</h4>
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Expiry Date</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $documents = \App\Models\VehicleDocument::where('vehicle_id', $vehicle->id)->get();
                                    @endphp
                                    @forelse($documents as $document)
                                        @php
                                            $expiryClass = '';
                                            if ($document->expiry_date) {
                                                $expiry = \Carbon\Carbon::parse($document->expiry_date);
                                                $now = \Carbon\Carbon::now();
                                                $diffInDays = $now->diffInDays($expiry, false);
                                                if ($expiry < $now || $diffInDays <= 10) {
                                                    $expiryClass = 'text-danger';
                                                } elseif ($diffInDays <= 30) {
                                                    $expiryClass = 'text-warning';
                                                } else {
                                                    $expiryClass = 'text-success';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $document->name }}</td>
                                            <td>
                                                @if($document->expiry_date)
                                                    <span class="{{ $expiryClass }}">{{ \Carbon\Carbon::parse($document->expiry_date)->format('d-m-Y') }}</span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset($document->document_url) }}" target="_blank" style="color:#007bff;font-weight:bold;">View Document</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3">No documents available</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
