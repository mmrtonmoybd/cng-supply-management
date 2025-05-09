@extends('boilerplate::layout.index', [
    'title' => 'Load Entry',
    'subtitle' => 'Load Entry lists',
    'breadcrumb' => [
        'Load Entry' => 'backend.load.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{route('backend.load.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Load Entry
                    
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="loadentry" />
    </x-boilerplate::card>
@endsection