@extends('boilerplate::layout.index', [
    'title' => 'Edit Cashbook',
    'subtitle' => 'Edit Cashbook',
    'breadcrumb' => [
        'Cashbook' => 'backend.calculations.index',
    ]
])

@section('content')

<div class="container">
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3>Edit Cashbook</h3>
            <a href="{{ route('backend.calculations.index') }}" class="btn btn-light">Back to List</a>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.calculations.update', $calculation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="name" class="h5">Cashbook Name</label>
                    <input type="text" name="name" class="form-control form-control-lg rounded" value="{{ $calculation->name }}" placeholder="Enter cashbook name">
                </div>

                <div class="form-group mb-4">
                <x-boilerplate::datetimepicker name="date" clearable=true placeholder='Date' required label="Date" value="{{$calculation->date}}" format="D/M/Y"/>
                </div>

                <!-- Grid system to divide the income and expense entries -->
                <div class="row">
                    <!-- Left Side: Income Entries -->
                    <div class="col-md-6">
                        <h4 class="text-success">Income Entries</h4>
                        <div id="income-entries">
                            @foreach($calculation->incomeEntries as $index => $income)
                                <div class="card shadow-sm p-3 mb-3" id="income-{{ $income->id }}">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="text-success">Income Entry {{ $index + 1 }}</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-entry" data-id="{{ $income->id }}" data-type="income">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <label for="income[{{ $index }}][description]">Description</label>
                                        <input type="text" name="income[{{ $index }}][description]" class="form-control" value="{{ $income->description }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="income[{{ $index }}][amount]">Amount</label>
                                        <input type="text" name="income[{{ $index }}][amount]" class="form-control" value="{{ $income->amount }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="income[{{ $index }}][category_id]">Entries heading</label>
                                        <select name="income[{{ $index }}][category_id]" class="form-control">
                                            <option value="">No Entries heading</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $income->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-success mt-3" id="add-income">
                            <i class="fas fa-plus-circle"></i> Add Income
                        </button>
                    </div>

                    <!-- Right Side: Expense Entries -->
                    <div class="col-md-6">
                        <h4 class="text-danger">Expense Entries</h4>
                        <div id="expense-entries">
                            @foreach($calculation->expenseEntries as $index => $expense)
                                <div class="card shadow-sm p-3 mb-3" id="expense-{{ $expense->id }}">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="text-danger">Expense Entry {{ $index + 1 }}</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-entry" data-id="{{ $expense->id }}" data-type="expense">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <label for="expense[{{ $index }}][description]">Description</label>
                                        <input type="text" name="expense[{{ $index }}][description]" class="form-control" value="{{ $expense->description }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="expense[{{ $index }}][amount]">Amount</label>
                                        <input type="text" name="expense[{{ $index }}][amount]" class="form-control" value="{{ $expense->amount }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="expense[{{ $index }}][category_id]">Entries heading</label>
                                        <select name="expense[{{ $index }}][category_id]" class="form-control">
                                            <option value="">No Entries heading</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-danger mt-3" id="add-expense">
                            <i class="fas fa-plus-circle"></i> Add Expense
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 float-right shadow">Update Cashbook</button>
            </form>
        </div>
    </div>
</div>

<script>
let incomeCount = {{ $calculation->incomeEntries->count() }}; // Tracks existing income entries
let expenseCount = {{ $calculation->expenseEntries->count() }}; // Tracks existing expense entries

// Helper function to create a new card for income or expense
function createCard(type, count) {
    return `
        <div class="card shadow-sm p-3 mb-3" id="new-${type}-${count}">
            <div class="d-flex justify-content-between">
                <h5 class="text-${type === 'income' ? 'success' : 'danger'}">${type.charAt(0).toUpperCase() + type.slice(1)} Entry ${count + 1}</h5>
                <button type="button" class="btn btn-sm btn-outline-danger remove-entry" data-id="new-${type}-${count}" data-type="${type}">
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
                <label for="${type}[${count}][category_id]">Entries heading</label>
                <select name="${type}[${count}][category_id]" class="form-control">
                    <option value="">No Entries heading</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    `;
}

// Add new income entry
document.getElementById('add-income').addEventListener('click', function () {
    let newEntry = createCard('income', incomeCount);
    document.getElementById('income-entries').insertAdjacentHTML('beforeend', newEntry);
    incomeCount++; // Increment the count for income entries
});

// Add new expense entry
document.getElementById('add-expense').addEventListener('click', function () {
    let newEntry = createCard('expense', expenseCount);
    document.getElementById('expense-entries').insertAdjacentHTML('beforeend', newEntry);
    expenseCount++; // Increment the count for expense entries
});

// Delegate remove entry event to dynamically created elements
document.addEventListener('click', function (event) {
    if (event.target.closest('.remove-entry')) {
        const button = event.target.closest('.remove-entry');
        const entryId = button.dataset.id;
        const entryType = button.dataset.type;
        
        if (confirm('Are you sure you want to delete this entry?')) {
            document.getElementById(`${entryType}-${entryId}`).remove();
        }
    }
});

</script>

@endsection
