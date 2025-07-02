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
            
            // Validasi varian yang dipilih
            $selectedVariants = [];
            $additionalPrice = 0;
            if ($request->has('selected_variants')) {
                $variantIds = explode(',', $request->selected_variants);
                foreach ($variantIds as $variantId) {
                    try {
                        $variant = ProductVariant::findOrFail($variantId);
                    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                        return back()->with('error', 'Gagal menambahkan produk ke keranjang: anda harus memilih variant');
                    }
                    if ($variant->product_id !== $product->id) {
                        return back()->with('error', 'Varian yang dipilih tidak valid.');
                    }
                    if ($variant->stock < $quantity) {
                        return back()->with('error', 'Stok varian ' . $variant->name . ' tidak mencukupi.');
                    }
                    $selectedVariants[] = $variant;
                    $additionalPrice += $variant->additional_price;
                }
            }

            // Hitung total harga dengan varian
            $totalPrice = $product->harga + $additionalPrice;

            $cart = session()->get('cart', []);
            $cartKey = $id;
            
            // Jika ada varian, tambahkan ke cart key
            if (!empty($selectedVariants)) {
                $variantKey = implode('-', array_map(fn($v) => $v->id, $selectedVariants));
                $cartKey .= '-' . $variantKey;
            }

            if (isset($cart[$cartKey])) {
                // Jika produk dengan varian yang sama sudah ada di keranjang
                $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
                
                // Cek stok untuk setiap varian
                foreach ($selectedVariants as $variant) {
                    if ($newQuantity > $variant->stock) {
                        return back()->with('error', 'Total jumlah di keranjang melebihi stok yang tersedia untuk varian ' . $variant->name);
                    }
                }
                
                $cart[$cartKey]['quantity'] = $newQuantity;
            } else {
                // Jika produk dengan varian belum ada di keranjang
                $cart[$cartKey] = [
                    'nama' => $product->nama,
                    'harga' => $product->harga,
                    'additional_price' => $additionalPrice,
                    'foto' => $product->foto,
                    'quantity' => $quantity,
                    'variants' => array_map(function($variant) {
                        return [
                            'id' => $variant->id,
                            'name' => $variant->name,
                            'type' => $variant->type,
                            'additional_price' => $variant->additional_price,
                            'stock' => $variant->stock,
                        ];
                    }, $selectedVariants)
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
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return back()->with('error', 'Gagal menambahkan produk ke keranjang: anda harus memilih variant');
            }
            return back()->with('error', 'Gagal menambahkan produk ke keranjang: ' . $e->getMessage());
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
    public function remove($cartKey) 
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
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
        foreach ($cart as $cartKey => $item) {
            $subtotal = $item['harga'] * $item['quantity'];
            $total += $subtotal;
            $items[] = [
                'id' => explode('-', $cartKey)[0], // Ambil ID produk dari cart key
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'quantity' => $item['quantity'],
                'variants' => $item['variants'] ?? [],
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
