<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CheckoutController extends Controller
{
    // Tampilkan form checkout dengan data produk dari query parameter
    public function show(Request $request)
    {
        $productName = $request->query('product_name', 'Produk Tidak Diketahui');
        $price = $request->query('price', 0);

        return view('ecatalog.checkout', compact('productName', 'price'));
    }

    // Proses submit pesanan
    public function submit(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'alamat'    => 'required|string',
            'telepon'   => 'required|string',
            'produk'    => 'required|string',
            'harga'     => 'required|numeric|min:0',
        ]);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->produk = $request->produk;
        $order->harga = $request->harga;
        $order->user_name = $request->user_name;
        $order->email = $request->email;
        $order->alamat = $request->alamat;
        $order->telepon = $request->telepon;
        $order->status = 'pending';

        $order->save();

        return redirect()->route('order.status')->with('success', 'Pesanan berhasil dikirim!');
    }

    // Halaman status pesanan
    public function status()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('ecatalog.status', compact('orders')); // ✅ path view yang benar
    }

public function statusDetail($id)
{
    $order = Order::where('id', $id)
                  ->where('user_id', Auth::id())
                  ->firstOrFail();

    return view('ecatalog.statusdetail', compact('order'));
}



}
