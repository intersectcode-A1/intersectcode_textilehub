<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\StockReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Build query with search and filter
        $query = Product::with(['category', 'variants']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('satuan', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'name_asc':
                    $query->orderBy('nama', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('nama', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'stock_low':
                    $query->orderBy('stok', 'asc');
                    break;
                case 'stock_high':
                    $query->orderBy('stok', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        // Paginate with query string preservation
        $products = $query->paginate(10)->withQueryString();
        
        // Check if all products have empty stock
        $semuaKosong = $products->count() > 0 && $products->every(fn ($p) => $p->stok == 0);
        
        // Get categories for filter dropdown
        $categories = Category::all();

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
            'variants.*.type' => 'required_with:variants|string|max:50',
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
            'variants.*.type' => 'required_with:variants|string|max:50',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.additional_price' => 'required_with:variants|numeric|min:0',
        ]);

        if ($request->hasFile('foto')) {
            if ($product->foto) Storage::disk('public')->delete($product->foto);
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $product->update($data);

        // Handle variants properly
        if ($request->has('variants')) {
            $submittedVariantIds = [];
            
            foreach ($request->variants as $variantData) {
                if (isset($variantData['id']) && !empty($variantData['id'])) {
                    // Update existing variant
                    $variant = $product->variants()->find($variantData['id']);
                    if ($variant) {
                        $variant->update([
                            'type' => $variantData['type'],
                            'name' => $variantData['name'],
                            'stock' => $variantData['stock'],
                            'additional_price' => $variantData['additional_price']
                        ]);
                        $submittedVariantIds[] = $variant->id;
                    }
                } else {
                    // Create new variant
                    $newVariant = $product->variants()->create([
                        'type' => $variantData['type'],
                        'name' => $variantData['name'],
                        'stock' => $variantData['stock'],
                        'additional_price' => $variantData['additional_price']
                    ]);
                    $submittedVariantIds[] = $newVariant->id;
                }
            }
            
            // Delete variants that were not submitted (removed from frontend)
            $product->variants()->whereNotIn('id', $submittedVariantIds)->delete();
        } else {
            // If no variants submitted, delete all existing variants
            $product->variants()->delete();
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->foto) Storage::disk('public')->delete($product->foto);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function exportStock()
    {
        return Excel::download(new StockReportExport, 'laporan_stok_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
