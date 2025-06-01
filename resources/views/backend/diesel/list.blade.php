@extends('boilerplate::layout.index', [
    'title' => 'Diesel',
    'subtitle' => 'Diesel lists',
    'breadcrumb' => [
        'Diesel' => 'backend.diesel.index',
    ]
])l

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <a href="" class="btn btn-primary ml-2">
                    <i class="fas fa-filter"></i> Advanced Filter
                </a>
            </span>
            <span class="float-right pb-3">
                <a href="{{ route('backend.diesel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Diesel
                </a>
            </span>
        </div>
    </div>

    <div class="row" id="settingcard" style="display:none;">
        <div class="col-12">
            <x-boilerplate::card>
                <form action="{{ route('backend.diesel.filter') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="date_range">Date Range</label>
                            <inpu type="text" name="use_liter" id="date_range" class="form-control" value="{{ request('date_range') }}" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter by Date</button>
                        </div>
                    </div>
                </form>
            </x-boilerplate::card>
        </div>
    </div>

    <x-boilerplate::card>
    <x-boilerplate::datatable name="diesel" />
    </x-boilerplate::card>
@endsection
