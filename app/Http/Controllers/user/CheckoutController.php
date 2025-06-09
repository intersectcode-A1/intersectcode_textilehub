<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan form checkout untuk produk tunggal
     */
    public function showDirect($id)
    {
        try {
            $product = Product::findOrFail($id);
            $quantity = request('quantity', 1);

            // Validasi stok
            if ($quantity > $product->stok) {
                return redirect()->route('ecatalog.detail', $id)
                    ->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }

            return view('ecatalog.checkout', [
                'productId' => $product->id,
                'productName' => $product->nama,
                'price' => $product->harga * $quantity,
                'quantity' => $quantity
            ]);

        } catch (\Exception $e) {
            return redirect()->route('ecatalog.index')
                ->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Submit order untuk checkout langsung
     */
    public function submit(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500'
            ]);

            $product = Product::findOrFail($request->product_id);
            
            // Validasi stok
            if ($request->quantity > $product->stok) {
                return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => $product->harga * $request->quantity,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            // Buat order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->harga
            ]);

            // Kurangi stok
            $product->decrement('stok', $request->quantity);

            DB::commit();

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Submit order dari keranjang
     */
    public function submitFromCart(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500'
            ]);

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return back()->with('error', 'Keranjang belanja kosong.');
            }

            $total = 0;
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if (!$product || $details['quantity'] > $product->stok) {
                    return back()->with('error', 'Beberapa produk tidak tersedia atau stok tidak mencukupi.');
                }
                $total += $product->harga * $details['quantity'];
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => $total,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            // Buat order items dan kurangi stok
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $product->harga
                ]);
                $product->decrement('stok', $details['quantity']);
            }

            // Kosongkan keranjang
            session()->forget('cart');

            DB::commit();

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
