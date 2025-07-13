<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categories = ExpenseCategory::withCount('expenses')
            ->withSum('expenses', 'nominal')
            ->orderBy('nama')
            ->paginate($perPage);

        return view('admin.expense_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.expense_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:expense_categories',
            'deskripsi' => 'nullable|string',
        ]);

        ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index')
            ->with('success', 'Kategori pengeluaran berhasil ditambahkan');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.expense_categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:expense_categories,nama,' . $expenseCategory->id,
            'deskripsi' => 'nullable|string',
        ]);

        $expenseCategory->update($request->all());

        return redirect()->route('expense-categories.index')
            ->with('success', 'Kategori pengeluaran berhasil diperbarui');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->count() > 0) {
            return redirect()->route('expense-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data pengeluaran');
        }

        $expenseCategory->delete();

        return redirect()->route('expense-categories.index')
            ->with('success', 'Kategori pengeluaran berhasil dihapus');
    }
} 