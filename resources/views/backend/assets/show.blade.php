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
                    <tr>
                        <th colspan="2">
                            <h4 class="mb-3 mt-4">Asset Documents</h4>
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $documents = \App\Models\AssetDocument::where('asset_id', $asset->id)->get();
                                    @endphp
                                    @forelse($documents as $document)
                                        <tr>
                                            <td>{{ $document->name }}</td>
                                            <td>
                                                <a href="{{ asset($document->document_url) }}" target="_blank" style="color:#007bff;font-weight:bold;">View Document</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2">No documents available</td></tr>
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
