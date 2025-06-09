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
            
            // Validasi jumlah yang diminta
            $quantity = $request->input('quantity', 1);
            if ($quantity > $product->stok) {
                return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                // Jika produk sudah ada di keranjang, tambahkan quantity
                $newQuantity = $cart[$id]['quantity'] + $quantity;
                if ($newQuantity > $product->stok) {
                    return back()->with('error', 'Total jumlah di keranjang melebihi stok yang tersedia.');
                }
                $cart[$id]['quantity'] = $newQuantity;
            } else {
                // Jika produk belum ada di keranjang
                $cart[$id] = [
                    'nama' => $product->nama,
                    'harga' => $product->harga,
                    'foto' => $product->foto,
                    'quantity' => $quantity
                ];
            }

            session()->put('cart', $cart);

            // Hitung total item di keranjang
            $totalItems = $this->getTotalItems();

            return back()->with([
                'success' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $totalItems
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan produk ke keranjang.');
        }
    }

    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalItems = $this->getTotalItems();
        return view('ecatalog.cart', compact('cart', 'totalItems'));
    }

    // Hapus produk dari keranjang
    public function remove($id) 
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $totalItems = $this->getTotalItems();
        return redirect()->route('cart.index')->with([
            'success' => 'Produk berhasil dihapus dari keranjang.',
            'cartCount' => $totalItems
        ]);
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

        $totalItems = $this->getTotalItems();
        return view('ecatalog.checkout-cart', [
            'items' => $items,
            'total' => $total,
            'totalItems' => $totalItems
        ]);
    }

    // Helper method untuk menghitung total item di keranjang
    private function getTotalItems()
    {
        $cart = session()->get('cart', []);
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }
        return $totalItems;
    }
}
