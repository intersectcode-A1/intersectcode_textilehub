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
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500'
            ]);

            $product = Product::findOrFail($request->product_id);
            
            // Validasi stok
            if ($request->quantity > $product->stok) {
                return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $product->harga * $request->quantity,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat
            ]);

            // Buat order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->nama,
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
            \Log::error('Checkout Error: ' . $e->getMessage());
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
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'items' => 'required|array',
                'total' => 'required|numeric|min:0'
            ]);

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return back()->with('error', 'Keranjang belanja kosong.');
            }

            // Generate nomor pesanan
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $request->total,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat
            ]);

            // Decode items dari form
            $items = array_map(function($item) {
                return json_decode($item, true);
            }, $request->items);

            // Buat order items dan kurangi stok
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                
                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($item['quantity'] > $product->stok) {
                    throw new \Exception("Stok produk {$product->nama} tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['nama'],
                    'quantity' => $item['quantity'],
                    'price' => $item['harga']
                ]);

                $product->decrement('stok', $item['quantity']);
            }

            // Kosongkan keranjang
            session()->forget('cart');

            DB::commit();

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
