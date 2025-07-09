@extends('boilerplate::layout.index', [
    'title' => 'Pump Name list',
    'subtitle' => 'Create Pump Name',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.pumpname.index') }}" class="btn btn-default" data-toggle="tooltip" title="Pump Name List">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
    </div>
</div>
<x-boilerplate::card>
    <form action="{{ route('backend.pumpname.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Type <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="Main" {{ old('type') == 'Main' ? 'selected' : '' }}>Main</option>
                        <option value="Third Party" {{ old('type') == 'Third Party' ? 'selected' : '' }}>Third Party</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                
                <label for="diesel">Diesel<span class="text-danger"></span></label>
                <select name="diesel" id="diesel" class="form-control" required>
                        <option value="">Diesel Type</option>
                        <option value="1" {{ old('diesel') == 1 ? 'selected' : '' }}>Only Diesel</option>
                        <option value="0" {{ old('diesel') == 0 ? 'selected' : '' }}>CNG + Diesel</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('backend.pumpname.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</x-boilerplate::card>
@endsection
