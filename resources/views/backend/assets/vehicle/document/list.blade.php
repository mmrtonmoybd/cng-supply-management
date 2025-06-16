@extends('boilerplate::layout.index', [
    'title' => __('Vehicle Documents'),
    'subtitle' => __('Vehicle Document List'),
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
                <a href="{{ route('backend.vehicle.vehicledocument.create') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-plus"></i> {{ __('Add Document') }}
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
        <x-boilerplate::datatable name="vehicledocument" />
    </x-boilerplate::card>
@endsection
