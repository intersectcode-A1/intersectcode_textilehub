<?php

namespace App\Http\Controllers;

use App\Models\Product;

class KatalogController extends Controller
{
    public function index()
    {
        $produk = Product::latest()->get(); // ambil semua produk
        return view('katalog.index', compact('produk')); // kirim ke view
    }
}


