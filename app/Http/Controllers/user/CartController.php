<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

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

            return back()->with([
                'success' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $this->getTotalItems()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan produk ke keranjang: ' . $e->getMessage());
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
        foreach ($cart as $id => $item) {
            $subtotal = $item['harga'] * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'id' => $id,
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'quantity' => $item['quantity'],
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
