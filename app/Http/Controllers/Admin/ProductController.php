<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan semua produk
   // Menampilkan semua produk
public function index()
{
    $products = Product::latest()->paginate(10);

    // Cek apakah semua stok produk = 0
    $semuaKosong = $products->count() > 0 && $products->every(function ($product) {
        return $product->stok == 0;
    });

    return view('admin.products.index', compact('products', 'semuaKosong'));
}

    // Menampilkan form tambah produk
    public function create()
    {
        return view('admin.products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
       $request->validate([
    'nama' => 'required|string|max:255',
    'harga' => 'required|numeric',
    'stok' => 'required|integer',
    'deskripsi' => 'nullable|string',
    'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ];

        // Jika ada upload foto baru, simpan dan hapus lama
        if ($request->hasFile('foto')) {
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        // Hapus file foto jika ada
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
