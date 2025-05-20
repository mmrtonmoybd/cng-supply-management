@extends('boilerplate::layout.index', [
    'title' => 'Factories',
    'subtitle' => 'Factory List',
])

@section('content')
<div class="row mb-3">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.factory.factory.create') }}" class="btn btn-primary float-right">
            <i class="fa fa-plus"></i> Add Factory
        </a>
    </div>
</div>
<x-boilerplate::card>
    <x-boilerplate::datatable name="factorylist" />
</x-boilerplate::card>
@endsection
