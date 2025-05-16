@extends('boilerplate::layout.index', [
    'title' => 'Dispenser',
    'subtitle' => 'Dispenser lists',
    'breadcrumb' => [
        'Dispenser' => 'backend.factory.dispansar.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.factory.dispansar.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{route('backend.factory.dispansar.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Dispenser
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="dispansar" />
    </x-boilerplate::card>
@endsection
