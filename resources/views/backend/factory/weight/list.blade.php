@extends('boilerplate::layout.index', [
    'title' => 'Weight scale',
    'subtitle' => 'Weight scale lists',
    'breadcrumb' => [
        'Weight' => 'backend.factory.weight.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.factory.weight.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{route('backend.factory.weight.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Weight Scale
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="weight" />
    </x-boilerplate::card>
@endsection
