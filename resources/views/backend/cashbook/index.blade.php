@extends('boilerplate::layout.index', [
    'title' => 'Cashbook',
    'subtitle' => 'Cashbook lists',
    'breadcrumb' => [
        'Cashbook' => 'backend.calculations.index',
    ]
])

@section('content')

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title">Cashbook Overview</h3>
        <a href="{{ route('backend.calculations.create') }}" class="btn btn-success">Create New Cashbook</a>
    </div>

    <div class="card-body">
        @if($calculationsData->isEmpty())
            <div class="alert alert-warning">No Cashbooks found.</div>
        @else
        <div class="table-responsive">
            <table class="table table-striped table-hover va-middle w-100 table-sm">
                <thead>
                    <tr>
                        <th>Cashbook Name</th>
                        <th>Date</th>
                        <th>Total Income</th>
                        <th>Total Expense</th>
                        <th>Net Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calculationsData as $calculation)
                    <tr>
                        <td>{{ (!empty($calculation['name'])) ? $calculation['name'] : 'N/A' }}</td>
                        <td>{{ $calculation['date'] }}</td>
                        <td>{{ number_format($calculation['totalIncome'], 2) }}</td>
                        <td>{{ number_format($calculation['totalExpense'], 2) }}</td>
                        <td>{{ number_format($calculation['netBalance'], 2) }}</td>
                        <td>
                            <a href="{{ route('backend.calculations.show', $calculation['id']) }}" class="btn btn-info btn-sm">View</a>
                            
                                <a href="{{ route('backend.calculations.edit', $calculation['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                            

                            
                            <form action="{{ route('backend.calculations.destroy', $calculation['id']) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Cashbook?');">Delete</button>
                            </form>
                            
                            
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $calculations->links() }}
            </div>
        @endif
    </div>
</div>

@endsection