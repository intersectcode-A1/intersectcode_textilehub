<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category'])
            ->withCount('orderItems')
            ->when($request->filled('search'), function ($q) use ($request) {
                return $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                return $q->where('category_id', $request->category);
            })
            ->when($request->filled('min_price'), function ($q) use ($request) {
                return $q->where('harga', '>=', $request->min_price);
            })
            ->when($request->filled('max_price'), function ($q) use ($request) {
                return $q->where('harga', '<=', $request->max_price);
            });

        // Sorting
        $query->when($request->filled('sort'), function ($q) use ($request) {
            return match ($request->sort) {
                'price_low' => $q->orderBy('harga', 'asc'),
                'price_high' => $q->orderBy('harga', 'desc'),
                'name_asc' => $q->orderBy('nama', 'asc'),
                'name_desc' => $q->orderBy('nama', 'desc'),
                default => $q->latest(),
            };
        }, function ($q) {
            return $q->latest();
        });

        $products = $query->paginate(12)->withQueryString();
        
        // Get categories with product count
        $categories = Category::withCount('products')->get();

        // Get price range for filters
        $priceRange = [
            'min' => Product::min('harga') ?? 0,
            'max' => Product::max('harga') ?? 1000000
        ];

        return view('ecatalog.index', compact('products', 'categories', 'priceRange'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'orderItems'])->findOrFail($id);
        return view('ecatalog.detail', compact('product'));
    }
}
