@extends('boilerplate::layout.index', [
    'title' => 'Assets',
    'subtitle' => 'Assets lists',
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{ route('backend.asset.asset.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Asset
                </a>
            </span>
            <span class="float-right pb-3 mr-2">
                <a href="{{ route('backend.asset.assetdocument.index') }}" class="btn btn-warning">
                    <i class="fas fa-folder-open"></i> Asset document
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="asset" />
    </x-boilerplate::card>
@endsection