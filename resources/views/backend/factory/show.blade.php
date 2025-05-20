@extends('boilerplate::layout.index', [
    'title' => 'Factory Details',
    'subtitle' => 'Show Factory',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.factory.factory.index') }}" class="btn btn-default" data-toggle="tooltip" title="Factory List">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
    </div>
</div>
<x-boilerplate::card>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tbody>
                    <tr><th>ID</th><td>{{ $factory->id }}</td></tr>
                    <tr><th>Name</th><td>{{ $factory->name }}</td></tr>
                    <tr><th>Type</th><td>{{ $factory->type }}</td></tr>
                    <tr><th>Address</th><td>{{ $factory->address }}</td></tr>
                    <tr><th>Email</th><td>{{ $factory->email }}</td></tr>
                    <tr><th>Phone</th><td>{{ $factory->phone }}</td></tr>
                    <tr><th>Created At</th><td>{{ $factory->created_at }}</td></tr>
                    <tr><th>Updated At</th><td>{{ $factory->updated_at }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</x-boilerplate::card>
@endsection
