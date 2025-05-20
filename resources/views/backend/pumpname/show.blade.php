@extends('boilerplate::layout.index', [
    'title' => 'Pump Name Details',
    'subtitle' => 'Show Pump Name',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.pumpname.index') }}" class="btn btn-default" data-toggle="tooltip" title="Pump Name List">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
    </div>
</div>
<x-boilerplate::card>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tbody>
                    <tr><th>ID</th><td>{{ $pumpname->id }}</td></tr>
                    <tr><th>Name</th><td>{{ $pumpname->name }}</td></tr>
                    <tr><th>Type</th><td>{{ $pumpname->type == 1 ? 'Main' : ($pumpname->type == 2 ? 'Third Party' : $pumpname->type) }}</td></tr>
                    <tr><th>Address</th><td>{{ $pumpname->address }}</td></tr>
                    <tr><th>Email</th><td>{{ $pumpname->email }}</td></tr>
                    <tr><th>Phone</th><td>{{ $pumpname->phone }}</td></tr>
                    <tr><th>Created At</th><td>{{ $pumpname->created_at }}</td></tr>
                    <tr><th>Updated At</th><td>{{ $pumpname->updated_at }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</x-boilerplate::card>
@endsection
