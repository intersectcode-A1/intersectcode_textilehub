<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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

        // Simpan pesanan ke database
        Order::create([
            'user_id'      => Auth::id(), // optional jika ada relasi user
            'email'        => Auth::user()->email, // ambil email dari yang login
            'nama'         => $validated['nama'],
            'alamat'       => $validated['alamat'],
            'telepon'      => $validated['telepon'],
            'product_id'   => $validated['product_id'],
            'product_name' => $validated['product_name'],
            'price'        => $validated['price'],
            'status'       => 'Diproses', // status default
        ]);

        // Redirect ke status pesanan
        return redirect()->route('order.status')->with('success', 'Pesanan berhasil dikirim!');
    }
}
