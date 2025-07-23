@extends('boilerplate::layout.index', [
    'title' => 'Cng Pump & Weight Scale',
    'subtitle' => 'Cng Pump & Weight Scale lists',
    'breadcrumb' => [
        'Cng Pump & Weight Scale' => 'backend.factory.weightone.index',
    ]
])

@include('components.datatable-highlight-css')
@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.factory.weightone.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>

            @can('invoice_crud')
            <span class="float-right pb-3 mr-2">
                <a href="{{ route('backend.factory.invoice.create') }}?factory=weightone" class="btn btn-success">
                    <i class="fas fa-file-invoice-dollar"></i> Invoice
                </a>
            </span>
            @endcan
            <span class="float-right pb-3 mr-2">
                <a href="{{route('backend.factory.weightone.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Cng Pump & Weight Scale
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="weightone" />
    </x-boilerplate::card>
@include('components.datatable-highlight-js')
@endsection
