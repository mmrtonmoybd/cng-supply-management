@extends('boilerplate::layout.index', [
    'title' => 'Vehicle maintenance',
    'subtitle' => 'Vehicle maintenance lists',
    'breadcrumb' => [
        'Vehicle maintenance' => 'backend.vehicle.vehiclemaintenance.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.vehicle.vehicle.index') }}" class="btn btn-default ml-2">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{route('backend.vehicle.vehiclemaintenance.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Vehicle maintenance
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="maintenance" />
    </x-boilerplate::card>
@endsection