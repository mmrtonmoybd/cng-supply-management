@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Load lists',
    'breadcrumb' => [
        'Load' => 'backend.load.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.load.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{route('backend.load.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Load
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="loadentry" />
    </x-boilerplate::card>
@endsection