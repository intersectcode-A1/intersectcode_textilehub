<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $price = $request->input('price');

        return view('ecatalog.checkout', compact('productId', 'productName', 'price'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'product_id' => 'required|integer',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Simpan ke database jika ingin, contoh:
        // Order::create($validated);

        return redirect()->route('ecatalog.index')->with('success', 'Pesanan berhasil dikirim!');
    }
}
