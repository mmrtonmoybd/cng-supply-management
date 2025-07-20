@extends('boilerplate::layout.index', [
    'title' => 'Pump Names list',
    'subtitle' => 'Pump Name List',
])

@include('components.datatable-highlight-css')
@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.pumpname.create') }}" class="btn btn-primary float-right">
            <i class="fa fa-plus"></i> Add Pump Name
        </a>
    </div>
</div>
<x-boilerplate::card>
    <x-boilerplate::datatable name="pumpname" />
</x-boilerplate::card>
@include('components.datatable-highlight-js')
@endsection
