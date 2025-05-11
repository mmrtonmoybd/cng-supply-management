@extends('boilerplate::layout.index', [
    'title' => 'Activity',
    'subtitle' => 'Activity lists',
    'breadcrumb' => [
        'Load' => 'backend.activity.index',
    ]
])

@section('content')
    <x-boilerplate::card>
    <x-boilerplate::datatable name="activitylog" />
    </x-boilerplate::card>
@endsection