<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Tambah produk ke keranjang
    public function add(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'nama' => $product->nama,
                    'harga' => $product->harga,
                    'foto' => $product->foto,
                    'quantity' => 1
                ];
            }

            session()->put('cart', $cart);

            // Kembali ke halaman sebelumnya dengan pesan sukses
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan produk ke keranjang.');
        }
    }

    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('ecatalog.cart', compact('cart'));  // Sesuaikan folder view-nya
    }

    // Hapus produk dari keranjang
    public function remove($id) 
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Checkout dari keranjang
    public function checkoutFromCart()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        // Hitung total harga
        $total = 0;
        $items = [];
        foreach ($cart as $id => $item) {
            $subtotal = $item['harga'] * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'id' => $id,
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ];
        }

        return view('ecatalog.checkout-cart', [
            'items' => $items,
            'total' => $total
        ]);
    }
}
