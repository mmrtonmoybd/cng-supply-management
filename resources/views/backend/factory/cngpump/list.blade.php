@extends('boilerplate::layout.index', [
    'title' => 'CNG Pump Slip',
    'subtitle' => 'CNG Pump Slip lists',
])

@include('components.datatable-highlight-css')
@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.factory.cngpump.filter') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>

            @can('invoice_crud')
            <span class="float-right pb-3 mr-2">
                <a href="{{ route('backend.factory.invoice.create') }}?factory=cngpump" class="btn btn-success">
                    <i class="fas fa-file-invoice-dollar"></i> Invoice
                </a>
            </span>
            @endcan
            <span class="float-right pb-3 mr-2">
                <a href="{{route('backend.factory.cngpump.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> CNG Pump
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="cngpumpslip" />
    </x-boilerplate::card>
@include('components.datatable-highlight-js')
@endsection
