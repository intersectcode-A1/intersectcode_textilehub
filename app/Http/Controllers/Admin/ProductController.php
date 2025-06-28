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
        $products = Product::with('category')->latest()->paginate(10);
        $semuaKosong = $products->count() > 0 && $products->every(fn($p) => $p->stok == 0);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'semuaKosong', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
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


        $data['foto'] = $this->handleFotoUpload($request);

        $product = Product::create($data);

        $this->handleVariants($request, $product);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', [
            'data' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('foto')) {
            $this->deleteFotoLama($product->foto);
            $data['foto'] = $this->handleFotoUpload($request);
        }

        $product->update($data);

        $this->handleVariants($request, $product, true);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $this->deleteFotoLama($product->foto);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // =======================
    // 🔽 Private helper methods
    // =======================

    private function validateProduct(Request $request): array
    {
        return $request->validate([
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
    }

    private function handleFotoUpload(Request $request): ?string
    {
        return $request->file('foto')?->store('produk', 'public');
    }

    private function deleteFotoLama(?string $foto): void
    {
        if ($foto) {
            Storage::disk('public')->delete($foto);
        }
    }

    private function handleVariants(Request $request, Product $product, bool $isUpdate = false): void
    {
        if ($isUpdate) {
            $product->variants()->delete();
        }

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $product->variants()->create([
                    'type' => $variant['type'],
                    'name' => $variant['name'],
                    'stock' => $variant['stock'],
                    'additional_price' => $variant['additional_price'],
                ]);
            }
        }
    }
}
