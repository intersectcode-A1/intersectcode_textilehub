<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // Constants for magic strings
    private const STATUS_PENDING = 'pending';
    private const PAYMENT_UNPAID = 'unpaid';
    private const ROLE_ADMIN = 'admin';

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
            $totalPrice = $this->calculateTotalPrice($product, $variants, $quantity);

            // Validasi stok (jika ada varian, cek stok varian terendah)
            $stockError = $this->validateStock($product, $variants, $quantity);
            if ($stockError) {
                return redirect()->route('ecatalog.show', $id)
                    ->with('error', $stockError);

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

    public function submit(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500'
            ]);

            $product = Product::findOrFail($request->product_id);

            $variantIds = $request->input('selected_variants', []);
            $variants = \App\Models\ProductVariant::whereIn('id', $variantIds)->get();
            $additionalPrice = $variants->sum('additional_price');
            $totalPrice = $this->calculateTotalPrice($product, $variants, $request->quantity);

            // Validasi stok varian
            $stockError = $this->validateStock($product, $variants, $request->quantity);
            if ($stockError) {
                throw new \Exception($stockError);

            }

            Log::info('Stock validation passed', ['product' => $product->toArray()]);

            // Generate nomor pesanan
            $orderNumber = $this->generateOrderNumber();

            // Buat order baru
            $order = $this->createOrder([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => self::STATUS_PENDING,
                'payment_status' => self::PAYMENT_UNPAID,
                'total' => $totalPrice,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat
            ]);

            Log::info('Order created', ['order' => $order->toArray()]);

            // Buat order item
            $this->createOrderItem($order, $product, $variants, $request->quantity, $product->harga + $additionalPrice);

            // Kurangi stok produk dan varian
            $this->decrementStock($product, $variants, $request->quantity);

            // Kirim notifikasi ke semua admin
            $this->notifyAdmins($order);

            DB::commit();

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submit: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function submitFromCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'user_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:500',
                'items' => 'required|array',
                'total' => 'required|numeric|min:0',
            ]);

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                throw new \Exception('Keranjang belanja kosong.');
            }

            // Generate nomor pesanan
            $orderNumber = $this->generateOrderNumber();

            // Buat order baru
            $order = $this->createOrder([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => self::STATUS_PENDING,
                'payment_status' => self::PAYMENT_UNPAID,
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


            // Validasi semua stok
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
                    'price' => $item['harga'] + (isset($item['variants']) ? collect($item['variants'])->sum('additional_price') : 0),
                    'variant_info' => isset($item['variants']) ? $item['variants'] : null,
                ]);
                Log::info('Cart order item created', ['orderItem' => $orderItem->toArray()]);
                $product->decrement('stok', $item['quantity']);
            }
            $this->notifyAdmins($order);

            session()->forget('cart');
            DB::commit();

            return redirect()->route('order.status')
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submitFromCart: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    // =====================
    // PRIVATE HELPER METHODS
    // =====================

    /**
     * Validasi stok produk/varian
     * @return string|null pesan error jika stok tidak cukup, null jika stok cukup
     */
    private function validateStock($product, $variants, $quantity)
    {
        if ($variants->count() > 0) {
            foreach ($variants as $variant) {
                if ($quantity > $variant->stock) {
                    return 'Jumlah yang diminta melebihi stok varian yang tersedia.';
                }
            }
        } else {
            if ($quantity > $product->stok) {
                return 'Jumlah yang diminta melebihi stok yang tersedia.';
            }
        }
        return null;
    }

    /**
     * Hitung total harga
     */
    private function calculateTotalPrice($product, $variants, $quantity)
    {
        $additionalPrice = $variants->sum('additional_price');
        return ($product->harga + $additionalPrice) * $quantity;
    }

    /**
     * Generate nomor pesanan unik
     */
    private function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    /**
     * Buat order baru
     */
    private function createOrder($data)
    {
        return Order::create($data);
    }

    /**
     * Buat order item untuk checkout langsung
     */
    private function createOrderItem($order, $product, $variants, $quantity, $price)
    {
        return OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->nama,
            'quantity' => $quantity,
            'price' => $price,
            'variant_info' => $variants->map(function($variant) {
                return [
                    'id' => $variant->id,
                    'name' => $variant->name,
                    'type' => $variant->type,
                    'additional_price' => $variant->additional_price,
                ];
            })->values()->toArray(),
        ]);
    }

    /**
     * Kurangi stok produk/varian
     */
    private function decrementStock($product, $variants, $quantity)
    {
        if ($variants->count() > 0) {
            foreach ($variants as $variant) {
                $variant->decrement('stock', $quantity);
            }
        } else {
            $product->decrement('stok', $quantity);
        }
    }

    /**
     * Kirim notifikasi ke semua admin
     */
    private function notifyAdmins($order)
    {
        $admins = User::where('role', self::ROLE_ADMIN)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }
    }
}
