@extends('boilerplate::layout.index', [
    'title' => 'Create Cashbook',
    'subtitle' => 'Create Cashbook',
    'breadcrumb' => [
        'Cashbook' => 'backend.calculations.create',
    ]
])

@section('content')
<x-boilerplate::form route='backend.calculations.store'>
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.calculations.index') }}" class="btn btn-default" data-toggle="tooltip" title="Cashbook lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    Save Cashbook
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
<x-boilerplate::card>
    <div class="row">
        <div class="col-6">
            <label for="name" class="h5">Cashbook date</label>
            <x-boilerplate::datetimepicker name="date" clearable=true placeholder='Date' required label="Date" value="{{\Illuminate\Support\Carbon::now()}}" format="D/M/Y"/>
            <small class="form-text text-muted">Select date otherwise current date will be apply</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-success">Income Entries</h4>
            <div id="income-entries"></div>
            <button type="button" class="btn btn-outline-success mt-3" id="add-income">
                <i class="fas fa-plus-circle"></i> Add Income
            </button>
        </div>
        <div class="col-md-6">
            <h4 class="text-danger">Expense Entries</h4>
            <div id="expense-entries"></div>
            <button type="button" class="btn btn-outline-danger mt-3" id="add-expense">
                <i class="fas fa-plus-circle"></i> Add Expense
            </button>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>

@push('js')
<script>
    let incomeCount = 0;
    let expenseCount = 0;

    // Helper function to create card wrapper for form entries
    function createCard(type, count) {
        return `
            <div class="card shadow-sm p-3 mb-3" id="${type}-${count}">
                <div class="d-flex justify-content-between">
                    <h5 class="text-${type === 'income' ? 'success' : 'danger'}">${type.charAt(0).toUpperCase() + type.slice(1)} Entry ${count + 1}</h5>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-${type}" data-count="${count}">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>
                </div>
                <div class="form-group">
                    <label for="${type}[${count}][description]">Description</label>
                    <input type="text" name="${type}[${count}][description]" class="form-control" placeholder="Enter description">
                </div>
                <div class="form-group">
                    <label for="${type}[${count}][amount]">Amount</label>
                    <input type="text" name="${type}[${count}][amount]" class="form-control" required placeholder="Enter amount">
                </div>
                <div class="form-group">
                    <label for="${type}[${count}][category_id]">Entries Heading</label>
                    <select name="${type}[${count}][category_id]" class="form-control" required>
                        <option value="">No Entries Heading</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        `;
    }

    // Add income entry
    document.getElementById('add-income').addEventListener('click', function () {
        let newEntry = createCard('income', incomeCount);
        document.getElementById('income-entries').insertAdjacentHTML('beforeend', newEntry);
        incomeCount++;
    });

    // Add expense entry
    document.getElementById('add-expense').addEventListener('click', function () {
        let newEntry = createCard('expense', expenseCount);
        document.getElementById('expense-entries').insertAdjacentHTML('beforeend', newEntry);
        expenseCount++;
    });

    // Remove dynamic income entry
    document.getElementById('income-entries').addEventListener('click', function (e) {
        if (e.target.closest('.remove-income')) {
            let count = e.target.closest('.remove-income').dataset.count;
            document.getElementById(`income-${count}`).remove();
        }
    });

    // Remove dynamic expense entry
    document.getElementById('expense-entries').addEventListener('click', function (e) {
        if (e.target.closest('.remove-expense')) {
            let count = e.target.closest('.remove-expense').dataset.count;
            document.getElementById(`expense-${count}`).remove();
        }
    });
</script>
@endpush
@endsection
