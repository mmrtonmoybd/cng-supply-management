@extends('boilerplate::layout.index', [
    'title' => __('Asset Documents'),
    'subtitle' => __('Asset Document List'),
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.asset.asset.index') }}" class="btn btn-default ml-2">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{ route('backend.asset.assetdocument.create') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-plus"></i> {{ __('Add Document') }}
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
        <x-boilerplate::datatable name="assetdocument" />
    </x-boilerplate::card>
@endsection