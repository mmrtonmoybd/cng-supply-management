@extends('boilerplate::layout.index', [
    'title' => 'Diesel',
    'subtitle' => 'Diesel lists',
    'breadcrumb' => [
        'Diesel' => 'backend.diesel.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <button class="btn btn-primary ml-2" id="toggleFilterBtn" type="button">
                    <i class="fas fa-calculator"></i> Use factor
                </button>
            </span>
            <span class="float-right pb-3">
                <a href="{{ route('backend.diesel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Diesel
                </a>
            </span>
        </div>
    </div>

    <div class="row" id="filterCard" style="display:none;">
        <div class="col-12">
            <x-boilerplate::card>
                <form action="{{ route('backend.diesel.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">                               <label>Use liter factor</label>
                            <input name='factor_liter' class="form-control" type="number" step="0.01" label='Use liter factor' value="{{ old('factor_liter', settings()->get('factor_liter')) }}" placeholder='Use liter factor' />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                              <label>Use balance factor</label>
                            <input name="factor_balance" class="form-control" type="number" step="0.01" label="Use balance factor" value="{{ old('factor_balance', settings()->get('factor_balance')) }}" placeholder='Use balance factor'/>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Use factor</button>
                        </div>
                    </div>
                </form>
            </x-boilerplate::card>
        </div>
    </div>

    <x-boilerplate::card>
    <x-boilerplate::datatable name="diesel" />
    </x-boilerplate::card>

    <script>
        document.getElementById('toggleFilterBtn').addEventListener('click', function() {
            var card = document.getElementById('filterCard');
            card.style.display = card.style.display === 'none' ? '' : 'none';
        });
    </script>
@endsection
