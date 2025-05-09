@extends('boilerplate::layout.index', [
    'title' => 'Load',
    'subtitle' => 'Load lists',
    'breadcrumb' => [
        'Load' => 'backend.load.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{route('backend.load.create')}}" class="btn btn-danger">
                    <i class="fas fa-plus"></i> Load
                    
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="loadentry" />
    </x-boilerplate::card>
@endsection