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
        <h3 class="card-title">Create Entries heading</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('backend.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Entries heading Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Entries heading name" required>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
</div>

@endsection