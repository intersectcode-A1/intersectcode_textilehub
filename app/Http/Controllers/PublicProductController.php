<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter pencarian nama produk jika ada input search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori jika ada input category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Ambil produk stok > 0 dengan pagination 12 per halaman, terbaru dulu
        $products = $query->where('stok', '>', 0)->latest()->paginate(12);

        return view('ecatalog.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('ecatalog.detail', [
            'product' => $product,
            'checkoutUrl' => route('checkout', [
                'product_name' => $product->nama,
                'price' => $product->harga,
                'product_id' => $product->id
            ])
        ]);
    }
}
