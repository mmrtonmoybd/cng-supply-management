@extends('boilerplate::layout.index', [
    'title' => 'Entries Filter',
    'subtitle' => 'Filter by Category and Date',
    'breadcrumb' => [
        'Entries heading list' => 'backend.categories.index',
        'Filter' => 'backend.categories.filter',
    ]
])

@section('content')
<div class="row">
    <div class="col-12 pb-3">
        <a href="{{ route('backend.categories.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span>
        </a>
    </div>
</div>
<x-boilerplate::card>
    <form action="{{ route('backend.categories.filter') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control select2">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string)request('category_id') === (string)$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="date_range">Date Range</label>
                <input type="text" class="form-control" id="date_range" name="date_range" value="{{ request('date_range') }}" placeholder="YYYY-MM-DD - YYYY-MM-DD">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Income</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $incomeTotal = 0; @endphp
                    @forelse($incomeEntries as $entry)
                        <tr>
                            <td>
                                @php
                                $model = App\Models\Calculation::find($entry->calculation_id);
                                $date = (\Carbon\Carbon::parse($model->date)->format('d-m-Y'));
                                @endphp
                                {{ $date }}
                            </td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                        </tr>
                        @php $incomeTotal += $entry->amount; @endphp
                    @empty
                        <tr><td colspan="3" class="text-center">No income entries found.</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th>{{ number_format($incomeTotal, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6">
            <h5>Expense</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $expenseTotal = 0; @endphp
                    @forelse($expenseEntries as $entry)
                        <tr>
                            <td>
                                @php
                                $model = App\Models\Calculation::find($entry->calculation_id);
                                $date = (\Carbon\Carbon::parse($model->date)->format('d-m-Y'));
                                @endphp
                                {{ $date }}
                            </td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ number_format($entry->amount, 2) }}</td>
                        </tr>
                        @php $expenseTotal += $entry->amount; @endphp
                    @empty
                        <tr><td colspan="3" class="text-center">No expense entries found.</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th>{{ number_format($expenseTotal, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-boilerplate::card>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
@endpush
