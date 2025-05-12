@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Pump lists',
    'breadcrumb' => [
        'Pump' => 'backend.pump.index',
    ]
])

@section('content')
    <x-boilerplate::card>
    <x-boilerplate::datatable name="pump" />
    </x-boilerplate::card>
@endsection
