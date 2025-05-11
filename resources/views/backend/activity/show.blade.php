@extends('boilerplate::layout.index', [
    'title' => 'Activity Details',
    'subtitle' => 'View Activity',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.activity.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Activity Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>ID</th><td>{{ $activity->id }}</td></tr>
                    <tr><th>Module Name</th><td>{{ $activity->log_name }}</td></tr>
                    <tr><th>Action</th><td>{!! $activity->event === 'created' ? '<span class="badge badge-pill badge-success">Created</span>' : ($activity->event === 'updated' ? '<span class="badge badge-pill badge-warning">Updated</span>' : '<span class="badge badge-pill badge-danger">Deleted</span>') !!}</td></tr>
                    <tr><th>User</th><td>{{ $activity->causer ? $activity->causer->name : 'N/A' }}</td></tr>
                    <tr>
                        <th>Activity decription</th>
                        <td>
                            @php
                                $decoded = json_decode($activity->properties, true);
                            @endphp

                            @if(isset($decoded['attributes']) && isset($decoded['old']))
                                @foreach($decoded['attributes'] as $key => $newValue)
                                    <p>New {{ ucfirst($key) }} = {{ $newValue }}</p>
                                    <p>Old {{ ucfirst($key) }} = {{ $decoded['old'][$key] ?? 'N/A' }}</p>
                                @endforeach
                            @elseif(isset($decoded['attributes']))
                                @foreach($decoded['attributes'] as $key => $newValue)
                                    <p>New {{ ucfirst($key) }} = {{ $newValue }}</p>
                                @endforeach
                            @elseif(isset($decoded['old']))
                                @foreach($decoded['old'] as $key => $oldValue)
                                    <p>Old {{ ucfirst($key) }} = {{ $oldValue }}</p>
                                @endforeach
                            @else
                                <pre>{{ json_encode($decoded, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Activity At</th><td>{{ $activity->created_at->format('d-m-Y h:i A') }}</td></tr>
                    
                </tbody>
            </table>
        </x-boilerplate::card>
    </div>
</div>
@endsection
