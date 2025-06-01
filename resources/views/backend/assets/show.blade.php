@extends('boilerplate::layout.index', [
    'title' => 'Asset Details',
    'subtitle' => 'View Asset',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.asset.asset.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Asset Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>ID</th><td>{{ $asset->id }}</td></tr>
                    <tr><th>Asset Name</th><td>{{ $asset->name }}</td></tr>
                    <tr><th>Type</th><td>{{ $asset->type }}</td></tr>
                    <tr><th>Vehicle</th><td>{{ $asset->vehicle ? $asset->vehicle->vehicle_number : '-' }}</td></tr>

                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
