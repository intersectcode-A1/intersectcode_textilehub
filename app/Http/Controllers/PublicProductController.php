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

        // Filter berdasarkan range harga
        if ($request->has('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Ambil produk stok > 0 dengan pagination 12 per halaman
        $products = $query->where('stok', '>', 0)->paginate(12)->withQueryString();
        
        // Ambil semua kategori untuk filter
        $categories = Category::all();
        
        // Ambil min dan max harga untuk range slider
        $priceRange = [
            'min' => Product::min('harga'),
            'max' => Product::max('harga')
        ];

        return view('ecatalog.index', compact('products', 'categories', 'priceRange'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('ecatalog.detail', compact('product'));
    }
}
