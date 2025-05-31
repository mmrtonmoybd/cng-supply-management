@extends('boilerplate::layout.index', [
    'title' => 'Vehicle',
    'subtitle' => 'Vehicle lists',
    'breadcrumb' => [
        'Vehicle' => 'backend.asset.vehicle.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            
            <span class="float-right pb-3">
                <a href="{{route('backend.asset.vehicle.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Vehicle
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="vehicle" />
    </x-boilerplate::card>
@endsection
