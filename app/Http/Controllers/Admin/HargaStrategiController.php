<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\StrategiHargaExport;
use Maatwebsite\Excel\Facades\Excel;

class HargaStrategiController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get()->map(function($product) {
            $cost = $product->harga * 0.7;
            $margin = $product->harga > 0 ? (($product->harga - $cost) / $product->harga) * 100 : 0;
            $categoryAvg = $product->category ? Product::where('category_id', $product->category_id)->avg('harga') : $product->harga;
            $recommended = $categoryAvg ? round($categoryAvg * 1.1) : $product->harga;
            $product->margin = $margin;
            $product->recommended_price = $recommended;
            return $product;
        });
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
        $historyQuery = $product->priceHistory();
        $history = $historyQuery ? $historyQuery->with('user')->orderBy('created_at', 'asc')->get()->map(function($h) {
            return [
                'old_price' => $h->old_price,
                'new_price' => $h->new_price,
                'user' => $h->user ? $h->user->name : '-',
                'created_at' => $h->created_at->format('d-m-Y H:i')
            ];
        }) : collect();
        if (!$history || $history->isEmpty()) {
            $history = collect([
                [
                    'old_price' => $product->harga,
                    'new_price' => $product->harga,
                    'user' => '-',
                    'created_at' => $product->created_at ? $product->created_at->format('d-m-Y H:i') : now()->format('d-m-Y H:i')
                ]
            ]);
        }
        return response()->json(['history' => $history]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.harga-strategi.edit-harga', compact('product', 'categories'));
    }

    public function exportExcel()
    {
        return Excel::download(new StrategiHargaExport, 'strategi_harga.xlsx');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:products,id',
            'aksi' => 'required|in:naik,turun',
            'persen' => 'required|numeric|min:1|max:100',
        ]);
        $ids = $request->produk_id;
        $aksi = $request->aksi;
        $persen = $request->persen;
        $updated = 0;
        foreach (Product::whereIn('id', $ids)->get() as $product) {
            $old = $product->harga;
            if ($aksi === 'naik') {
                $product->harga = round($product->harga * (1 + $persen/100));
            } else {
                $product->harga = round($product->harga * (1 - $persen/100));
            }
            $product->save();
            if (method_exists($product, 'priceHistory')) {
                $product->priceHistory()->create([
                    'old_price' => $old,
                    'new_price' => $product->harga,
                    'user_id' => Auth::id(),
                ]);
            }
            $updated++;
        }
        return redirect()->route('admin.harga-strategi.index')->with('success', "Berhasil update harga $updated produk.");
    }
} 