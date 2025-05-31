@extends('boilerplate::layout.index', [
    'title' => 'Entries heading',
    'subtitle' => 'Edit Entries heading',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
    ]
])

@section('content')
<x-boilerplate::form :route="['backend.categories.update', $category->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.categories.index') }}" class="btn btn-default" data-toggle="tooltip" title="Entries heading list">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-boilerplate::card>
                <div class="row">
                    <div class="col-6">
                        <x-boilerplate::input name="name" label="Entries heading Name" required :value="old('name', $category->name)" placeholder="Enter Entries heading name" />
                    </div>
                </div>
            </x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection