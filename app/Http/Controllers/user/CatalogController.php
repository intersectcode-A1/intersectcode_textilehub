<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru, 9 per halaman
        $products = Product::latest()->paginate(9);

        // Kirim ke view
        return view('user.catalog.index', compact('products'));
    }

    public function show($id)
    {
        // Cari produk berdasar id, jika tidak ada tampil error 404
        $product = Product::findOrFail($id);

        return view('user.catalog.show', compact('product'));
    }
}
