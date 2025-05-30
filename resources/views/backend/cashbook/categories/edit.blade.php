@extends('boilerplate::layout.index', [
    'title' => 'Entries heading',
    'subtitle' => 'Entries heading edit',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
    ]
])

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Entries heading</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('backend.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Entries heading Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $category->name }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>

@endsection