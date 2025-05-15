@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Pump lists',
    'breadcrumb' => [
        'Pump' => 'backend.pump.index',
    ]
])

@section('content')
    <div class="mb-3">
        <a href="{{ route('backend.pump.filter') }}" class="btn btn-primary">
            <i class="fas fa-filter"></i> Advanced Filter
        </a>
    </div>
    
    <x-boilerplate::card>
        <x-boilerplate::datatable name="pump" />
    </x-boilerplate::card>
@endsection
