@extends('boilerplate::layout.index', [
    'title' => 'Category Details',
    'subtitle' => 'View Category',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
        'Show' => '',
    ]
])

@section('content')
<x-boilerplate::card>
    <h4>Category Details</h4>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $category->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $category->name }}</td>
        </tr>
    </table>
    <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary mt-2">Back to list</a>
</x-boilerplate::card>
@endsection
