<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Muat relasi category dan unit
        $products = Product::with(['category'])->latest()->paginate(10);
        $semuaKosong = $products->count() > 0 && $products->every(fn ($p) => $p->stok == 0);
        $categories = Category::all(); // Tambahkan ini untuk dropdown filter
        return view('admin.products.index', compact('products', 'semuaKosong', 'categories'));
    }

    public function create()
    {
        $categories = Category::all(); // ambil semua kategori untuk dropdown
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|in:color,size',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.additional_price' => 'required_with:variants|numeric|min:0',
        ]);

        $path = $request->file('foto')?->store('produk', 'public');

        $product = Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'satuan' => $request->satuan,
            'deskripsi' => $request->deskripsi,
            'foto' => $path,
        ]);

        // Simpan varian jika ada
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $product->variants()->create([
                    'type' => $variantData['type'],
                    'name' => $variantData['name'],
                    'stock' => $variantData['stock'],
                    'additional_price' => $variantData['additional_price']
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // untuk dropdown edit
        return view('admin.products.edit', [
            'data' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|in:color,size',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.additional_price' => 'required_with:variants|numeric|min:0',
        ]);

        if ($request->hasFile('foto')) {
            if ($product->foto) Storage::disk('public')->delete($product->foto);
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $product->update($data);

        // Update varian
        if ($request->has('variants')) {
            // Hapus varian yang ada
            $product->variants()->delete();
            
            // Tambah varian baru
            foreach ($request->variants as $variantData) {
                $product->variants()->create([
                    'type' => $variantData['type'],
                    'name' => $variantData['name'],
                    'stock' => $variantData['stock'],
                    'additional_price' => $variantData['additional_price']
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->foto) Storage::disk('public')->delete($product->foto);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
