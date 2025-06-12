<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:color,size',
            'stock' => 'required|integer|min:0',
            'additional_price' => 'required|numeric|min:0'
        ]);

        $variant = $product->variants()->create([
            'name' => $request->name,
            'type' => $request->type,
            'stock' => $request->stock,
            'additional_price' => $request->additional_price
        ]);

        return redirect()->back()->with('success', 'Varian produk berhasil ditambahkan');
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:color,size',
            'stock' => 'required|integer|min:0',
            'additional_price' => 'required|numeric|min:0'
        ]);

        $variant->update([
            'name' => $request->name,
            'type' => $request->type,
            'stock' => $request->stock,
            'additional_price' => $request->additional_price
        ]);

        return redirect()->back()->with('success', 'Varian produk berhasil diperbarui');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->back()->with('success', 'Varian produk berhasil dihapus');
    }
} 