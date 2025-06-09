<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10);
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'simbol' => 'required|string|max:50|unique:units',
            'deskripsi' => 'nullable|string'
        ]);

        Unit::create($request->all());

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'simbol' => 'required|string|max:50|unique:units,simbol,' . $unit->id,
            'deskripsi' => 'nullable|string'
        ]);

        $unit->update($request->all());

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil diperbarui');
    }

    public function destroy(Unit $unit)
    {
        if($unit->products()->exists()) {
            return redirect()->route('units.index')
                ->with('error', 'Satuan tidak dapat dihapus karena masih digunakan oleh produk');
        }

        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'Satuan berhasil dihapus');
    }
} 