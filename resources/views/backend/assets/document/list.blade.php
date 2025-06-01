@extends('boilerplate::layout.index', [
    'title' => __('Asset Documents'),
    'subtitle' => __('Asset Document List'),
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
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