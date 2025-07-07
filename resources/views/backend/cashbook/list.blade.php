@extends('boilerplate::layout.index', [
    'title' => 'Cashbook',
    'subtitle' => 'Cashbook lists',
    'breadcrumb' => [
        'Cashbook' => 'backend.calculations.index',
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-left pb-3">
                <button class="btn btn-primary ml-2" id="toggleFilterBtn" type="button">
                    <i class="fas fa-filter"></i> Advanced Filter
                </button>
            </span>
            <span class="float-right pb-3">
                <a href="{{route('backend.calculations.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Cashbook
                </a>
            </span>
        </div>
    </div>
    <div class="row" id="filterCard" style="display:none;">
        <div class="col-12">
            <x-boilerplate::card>
                <form action="{{ route('backend.calculations.filter') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="date_range">Date Range</label>
                            <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" placeholder="YYYY-MM-DD - YYYY-MM-DD">
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
    <x-boilerplate::datatable name="cashbook" />
    </x-boilerplate::card>
    <script>
        document.getElementById('toggleFilterBtn').addEventListener('click', function() {
            var card = document.getElementById('filterCard');
            card.style.display = card.style.display === 'none' ? '' : 'none';
        });
    </script>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });
    @if(request('date_range'))
        var dates = '{{ request('date_range') }}'.split(' - ');
        $('#date_range').data('daterangepicker').setStartDate(dates[0]);
        $('#date_range').data('daterangepicker').setEndDate(dates[1]);
        $('#date_range').val('{{ request('date_range') }}');
    @endif
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
@endpush