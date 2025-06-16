@extends('boilerplate::layout.index', [
    'title' => 'Vehicle',
    'subtitle' => 'Vehicle lists',
    'breadcrumb' => [
        'Vehicle' => 'backend.vehicle.vehicle.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{route('backend.vehicle.vehicle.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Vehicle
                </a>
            </span>
            <span class="float-right pb-3 mr-2">
                <a href="{{ route('backend.vehicle.vehicledocument.index') }}" class="btn btn-warning">
                    <i class="fas fa-folder-open"></i> Vehicle document
                </a>
                <a href="{{ route('backend.vehicle.vehiclemaintenance.index') }}" class="btn btn-success">
                    <i class="fas fa-tools"></i> Maintenance
                </a>
            </span>
            
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="vehicle" />
    </x-boilerplate::card>
@endsection
