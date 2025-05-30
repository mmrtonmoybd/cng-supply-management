@extends('boilerplate::layout.index', [
    'title' => 'Invoice',
    'subtitle' => 'Invoice lists',
    'breadcrumb' => [
        'Invoice' => 'backend.factory.invoice.index',
    ]
])

@section('content')
    <x-boilerplate::card>
    <x-boilerplate::datatable name="invoice" />
    </x-boilerplate::card>
@endsection
