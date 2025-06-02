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

        // Redirect ke halaman keranjang
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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
}
