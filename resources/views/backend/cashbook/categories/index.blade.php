@extends('boilerplate::layout.index', [
    'title' => 'Entries heading',
    'subtitle' => 'Entries heading lists',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
    ]
])

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Entries heading List</h3>
        <a href="{{ route('backend.categories.create') }}" class="btn btn-primary float-right">Create New Entries heading</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        
                        <a href="{{ route('backend.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>  
                        

                        
                            <form action="{{ route('backend.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        
                        
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection