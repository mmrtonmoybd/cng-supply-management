@extends('boilerplate::layout.index', [
    'title' => 'Pump Names',
    'subtitle' => 'Pump Name List',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.pumpname.index') }}" class="btn btn-default" data-toggle="tooltip" title="Pump Name List">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
        <a href="{{ route('backend.pumpname.create') }}" class="btn btn-primary float-right">
            <i class="fa fa-plus"></i> Add Pump Name
        </a>
    </div>
</div>
<x-boilerplate::card>
    <x-boilerplate::datatable name="pumpname" />
</x-boilerplate::card>
@endsection
