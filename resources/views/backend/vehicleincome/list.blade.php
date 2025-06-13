@extends('boilerplate::layout.index', [
    'title' => 'Vehicle income',
    'subtitle' => 'Vehicle income lists',
    'breadcrumb' => [
        'Vehicle income' => 'backend.vehicleIncome.index',
    ]
])

@section('content')
<div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.vehicleIncome.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="vehicleincome" />
    </x-boilerplate::card>
@endsection