<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HargaStrategiController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.harga-strategi.index', compact('products', 'categories'));
    }

    public function updateHarga(Request $request, Product $product)
    {
        $request->validate([
            'new_price' => [
                'required',
                'numeric',
                'min:0',
                'max:9223372036854775807'
            ]
        ], [
            'new_price.max' => 'Harga maksimal adalah 19 digit (9.223.372.036.854.775.807).'
        ]);
        $old_price = $product->harga;
        $product->harga = $request->new_price;
        $product->save();
        // Catat riwayat jika ada tabel price_histories
        if (method_exists($product, 'priceHistory')) {
            $product->priceHistory()->create([
                'old_price' => $old_price,
                'new_price' => $request->new_price,
                'user_id' => Auth::id(),
            ]);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Harga produk berhasil diperbarui']);
        } else {
            return redirect()->route('admin.harga-strategi.index')->with('success', 'Harga produk berhasil diperbarui');
        }
    }

    public function getPriceHistory($id)
    {
        $product = Product::findOrFail($id);
        $history = $product->priceHistory()->with('user')->orderBy('created_at', 'desc')->get()->map(function($h) {
            return [
                'old_price' => $h->old_price,
                'new_price' => $h->new_price,
                'user' => $h->user ? $h->user->name : '-',
                'created_at' => $h->created_at->format('d-m-Y H:i')
            ];
        });
        return response()->json(['history' => $history]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.harga-strategi.edit-harga', compact('product', 'categories'));
    }
} 