<?php

namespace App\Http\Controllers\Cashbook;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the list of categories
    public function index()
    {
        return view('backend.cashbook.categories.index');
    }

    // Show form to create a new category
    public function create()
    {
        return view('backend.cashbook.categories.create');
    }

    // Store the newly created category in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('backend.categories.index')->with('success', 'Entries heading created successfully');
    }

    // Show form to edit an existing category
    public function edit(Category $category)
    {

        return view('backend.cashbook.categories.edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id.'|max:255',
        ]);

        $category->update($request->only('name'));

        return redirect()->route('backend.categories.index')->with('success', 'Entries heading updated successfully');
    }

    // Delete a category
    public function destroy(Category $category)
    {

        return response()->json(['success' => $category->delete() ?? false]);
    }

    // Show filter form and results for Income/Expense by category and date
    public function filter(Request $request)
    {
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
        $incomeEntries = $incomeQuery->orderByDesc('date')->get();
        $expenseEntries = $expenseQuery->orderByDesc('date')->get();

        return view('backend.cashbook.categories.filter', compact('categories', 'incomeEntries', 'expenseEntries', 'categoryId', 'dateRange'));
    }

    // Show a single category (for route compatibility)
    public function show(Category $category)
    {
        return view('backend.cashbook.categories.show', compact('category'));
    }

    public function filterShow(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $categoryId = $request->input('category_id');
        $dateRange = $request->input('date_range');
        $startDate = null;
        $endDate = null;
        return view('backend.cashbook.categories.filtershow', compact('categories', 'categoryId', 'dateRange'));
    }
}
