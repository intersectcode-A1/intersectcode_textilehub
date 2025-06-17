<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $variantIds = array_filter(explode(',', request('selected_variants', '')));
            $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->get();
            $additionalPrice = $variants->sum('additional_price');
            $totalPrice = ($product->harga + $additionalPrice) * $quantity;

            // Validasi stok (jika ada varian, cek stok varian terendah)
            if ($variants->count() > 0) {
                foreach ($variants as $variant) {
                    if ($quantity > $variant->stock) {
                        return redirect()->route('ecatalog.show', $id)
                            ->with('error', 'Jumlah yang diminta melebihi stok varian yang tersedia.');
                    }
                }
            } else {
                if ($quantity > $product->stok) {
                    return redirect()->route('ecatalog.show', $id)
                        ->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
                }
            }

            return view('ecatalog.checkout', [
                'productId' => $product->id,
                'productName' => $product->nama,
                'price' => $totalPrice,
                'quantity' => $quantity,
                'variants' => $variants,
                'additionalPrice' => $additionalPrice,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in showDirect: ' . $e->getMessage());
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

            Log::info('Starting order submission process', ['request' => $request->all()]);

            // Validasi input
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'selected_variants' => 'array',
                'selected_variants.*' => 'exists:product_variants,id',
            ]);

            $product = Product::findOrFail($request->product_id);
            $variantIds = $request->input('selected_variants', []);
            $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->get();
            $additionalPrice = $variants->sum('additional_price');
            $totalPrice = ($product->harga + $additionalPrice) * $request->quantity;

            // Validasi stok varian
            if ($variants->count() > 0) {
                foreach ($variants as $variant) {
                    if ($request->quantity > $variant->stock) {
                        throw new \Exception('Jumlah yang diminta melebihi stok varian yang tersedia.');
                    }
                }
            } else {
                if ($request->quantity > $product->stok) {
                    throw new \Exception('Jumlah yang diminta melebihi stok yang tersedia.');
                }
            }

            // Generate nomor pesanan
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $totalPrice,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat
            ]);

            // Buat order item
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->nama,
                'quantity' => $request->quantity,
                'price' => $product->harga + $additionalPrice,
                'variant_info' => $variants->map(function($variant) {
                    return [
                        'id' => $variant->id,
                        'name' => $variant->name,
                        'type' => $variant->type,
                        'additional_price' => $variant->additional_price,
                    ];
                })->values()->toArray(),
            ]);

            // Kurangi stok produk dan varian
            if ($variants->count() > 0) {
                foreach ($variants as $variant) {
                    $variant->decrement('stock', $request->quantity);
                }
            } else {
                $product->decrement('stok', $request->quantity);
            }

            DB::commit();
            Log::info('Order process completed successfully');

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error in submit:', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submit: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Submit order dari keranjang
     */
    public function submitFromCart(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Starting cart order submission process', ['request' => $request->all()]);

            // Validasi input
            $validated = $request->validate([
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'items' => 'required|array',
                'total' => 'required|numeric|min:0'
            ]);

            Log::info('Cart validation passed', ['validated' => $validated]);

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                throw new \Exception('Keranjang belanja kosong.');
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

            Log::info('Cart order created', ['order' => $order->toArray()]);

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

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['nama'],
                    'quantity' => $item['quantity'],
                    'price' => $item['harga']
                ]);

                Log::info('Cart order item created', ['orderItem' => $orderItem->toArray()]);

                $product->decrement('stok', $item['quantity']);
            }

            // Kosongkan keranjang
            session()->forget('cart');

            DB::commit();
            Log::info('Cart order process completed successfully');

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error in submitFromCart:', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submitFromCart: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
