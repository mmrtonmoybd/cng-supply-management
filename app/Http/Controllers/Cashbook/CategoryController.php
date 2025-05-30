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
        $categories = Category::all();

        return view('backend.cashbook.categories.index', compact('categories'));
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

        $category->delete();

        return redirect()->route('backend.categories.index')->with('success', 'Entries heading deleted successfully');
    }
}
