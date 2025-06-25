<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'produk' => 'required|string',
            'harga_modal' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|string',
        ]);

        $supplier = Supplier::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'produk' => $request->produk,
            'harga_modal' => $request->harga_modal,
            'deskripsi' => $request->deskripsi,
            'satuan' => $request->satuan,
        ]);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'produk' => $request->produk,
            'harga_modal' => $request->harga_modal,
            'deskripsi' => $request->deskripsi,
            'satuan' => $request->satuan,
        ]);

        return response()->json($supplier);
    }
} 