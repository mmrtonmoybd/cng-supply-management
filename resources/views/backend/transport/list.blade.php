@extends('boilerplate::layout.index', [
    'title' => 'Transport',
    'subtitle' => 'Transport lists',
    'breadcrumb' => [
        'Transport' => 'backend.transport.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            
            <span class="float-right pb-3">
                <a href="{{ route('backend.transport.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Transport
                </a>
            </span>
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="transport" />
    </x-boilerplate::card>
@endsection
