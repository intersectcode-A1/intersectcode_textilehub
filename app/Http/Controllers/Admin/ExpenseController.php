<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'user']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('expense_category_id', $request->category_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->get('per_page', 15);
        $expenses = $query->orderBy('tanggal', 'desc')
            ->paginate($perPage);

        $categories = ExpenseCategory::orderBy('nama')->get();

        return view('admin.expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('nama')->get();
        return view('admin.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $request->merge(['user_id' => auth()->id()]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('nama')->get();
        return view('admin.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil dihapus');
    }
} 