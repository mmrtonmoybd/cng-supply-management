<?php

namespace App\Http\Controllers\Cashbook;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use App\Models\Category;
use App\Models\ExpenseEntry;
use App\Models\IncomeEntry;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the list of categories
    public function index()
    {
        $this->authorize('cashbook_crud');

        return view('backend.cashbook.categories.index');
    }

    // Show form to create a new category
    public function create()
    {
        $this->authorize('cashbook_crud');

        return view('backend.cashbook.categories.create');
    }

    // Store the newly created category in the database
    public function store(Request $request)
    {
        $this->authorize('cashbook_crud');
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('backend.categories.index')->with('success', 'Entries heading created successfully');
    }

    // Show form to edit an existing category
    public function edit(Category $category)
    {
        $this->authorize('cashbook_crud');

        return view('backend.cashbook.categories.edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $this->authorize('cashbook_crud');

        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id.'|max:255',
        ]);

        $category->update($request->only('name'));

        return redirect()->route('backend.categories.index')->with('success', 'Entries heading updated successfully');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $this->authorize('cashbook_crud');

        return response()->json(['success' => $category->delete() ?? false]);
    }

    // Show filter form and results for Income/Expense by category and date
    public function filter(Request $request)
    {
        $this->authorize('cashbook_crud');
        $categories = Category::orderBy('name')->get();
        $categoryId = $request->input('category_id');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;
        if ($dateRange) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
        }

        $incomeQuery = \App\Models\IncomeEntry::query();
        $expenseQuery = \App\Models\ExpenseEntry::query();
        if ($categoryId) {
            $incomeQuery->where('category_id', $categoryId);
            $expenseQuery->where('category_id', $categoryId);
        }
        if ($startDate && $endDate) {
            $incomeQuery->whereBetween('date', [$startDate, $endDate]);
            $expenseQuery->whereBetween('date', [$startDate, $endDate]);
        }
        $incomeEntries = $incomeQuery->orderBy('date', 'ASC')->get();
        $expenseEntries = $expenseQuery->orderBy('date', 'ASC')->get();

        return view('backend.cashbook.categories.filter', compact('categories', 'incomeEntries', 'expenseEntries', 'categoryId', 'dateRange'));
    }

    // Show a single category (for route compatibility)
    public function show(Category $category)
    {
        $this->authorize('cashbook_crud');

        return view('backend.cashbook.categories.show', compact('category'));
    }

    public function filterShow(Request $request)
    {
        $this->authorize('cashbook_crud');
        $categories = Category::orderBy('name')->get();
        $categoryId = $request->input('category_id');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;

        return view('backend.cashbook.categories.filtershow', compact('categories', 'categoryId', 'dateRange'));
    }

    public function filterExport(Request $request)
    {
        $this->authorize('cashbook_crud');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;
        $categoryId = $request->input('category_id');
        if ($dateRange && strpos($dateRange, ' - ') !== false) {
            [$startDate, $endDate] = array_map('trim', explode(' - ', $dateRange));
        }
        $incomeEntries = collect();
        $expenseEntries = collect();
        $previousBalance = 0;
        $totalIncome = 0;
        $totalExpense = 0;
        $netChange = 0;
        $netBalance = 0;
        $range = '';
        $calculation = null;

        if ($startDate && $endDate) {
            // $calIds = Calculation::whereBetween('date', [$startDate, $endDate])->pluck('id')->toArray();
            if ($categoryId) {
                $incomeEntries = IncomeEntry::where('category_id', $categoryId)->whereBetween('date', [$startDate, $endDate]);
                $expenseEntries = ExpenseEntry::where('category_id', $categoryId)->whereBetween('date', [$startDate, $endDate]);
            } else {
                $incomeEntries = IncomeEntry::whereBetween('date', [$startDate, $endDate]);
                $expenseEntries = ExpenseEntry::whereBetween('date', [$startDate, $endDate]);
            }

            $previousIncome = Calculation::with('incomeEntries')->where('date', '<', $startDate)->get()->pluck('incomeEntries')->collapse()->sum('amount');
            $previousExpense = Calculation::with('expenseEntries')->where('date', '<', $startDate)->get()->pluck('expenseEntries')->collapse()->sum('amount');
            $previousBalance = $previousIncome - $previousExpense;
            $incomeEntries = $incomeEntries->orderBy('date', 'ASC')->get();
            $expenseEntries = $expenseEntries->orderBy('date', 'ASC')->get();
            $totalIncome = $incomeEntries->sum('amount');
            $totalExpense = $expenseEntries->sum('amount');
            $netChange = $totalIncome - $totalExpense;
            $netBalance = $previousBalance + $netChange;
            $range = $dateRange;
        }

        return view('backend.cashbook.export', compact('calculation', 'incomeEntries', 'expenseEntries', 'totalIncome', 'totalExpense', 'netBalance', 'previousBalance', 'startDate', 'endDate', 'range', 'dateRange'));
    }
}
