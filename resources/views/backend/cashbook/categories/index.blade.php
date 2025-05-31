@extends('boilerplate::layout.index', [
    'title' => 'Entries heading',
    'subtitle' => 'Entries heading lists',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="{{ route('backend.categories.filtershow') }}" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advance Filter
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{ route('backend.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Entries heading
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
        <x-boilerplate::datatable name="categoryentry" />
    </x-boilerplate::card>
@endsection