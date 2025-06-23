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
            $quantity = (int) $request->input('quantity', 1);

            if ($quantity > $product->stok) {
                return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }

            $cart = session()->get('cart', []);

            $cart[$id] = $this->updateCartItem($cart, $product, $quantity);

            session()->put('cart', $cart);

            return back()->with([
                'success' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $this->getTotalItems()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan produk ke keranjang.');
        }
    }

    // Tampilkan isi keranjang
    public function index()
    {
        return view('ecatalog.cart', [
            'cart' => session()->get('cart', []),
            'totalItems' => $this->getTotalItems()
        ]);
    }

    // Hapus produk dari keranjang
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with([
            'success' => 'Produk berhasil dihapus dari keranjang.',
            'cartCount' => $this->getTotalItems()
        ]);
    }

    // Checkout dari keranjang
    public function checkoutFromCart()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $subtotal = $item['harga'] * $item['quantity'];
            $items[] = array_merge($item, [
                'id' => $id,
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        return view('ecatalog.checkout-cart', [
            'items' => $items,
            'total' => $total,
            'totalItems' => $this->getTotalItems()
        ]);
    }

    // Hitung total item di keranjang
    private function getTotalItems()
    {
        return collect(session()->get('cart', []))
            ->sum(fn($item) => $item['quantity']);
    }

    // Helper untuk mengupdate item dalam keranjang
    private function updateCartItem(array $cart, Product $product, int $quantity)
    {
        $existingQty = $cart[$product->id]['quantity'] ?? 0;
        $newQty = $existingQty + $quantity;

        if ($newQty > $product->stok) {
            abort(400, 'Total jumlah di keranjang melebihi stok yang tersedia.');
        }

        return [
            'nama' => $product->nama,
            'harga' => $product->harga,
            'foto' => $product->foto,
            'quantity' => $newQty
        ];
    }
}
