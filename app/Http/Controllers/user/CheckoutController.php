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

            // Validasi stok
            if ($request->quantity > $product->stok) {
                throw new \Exception('Jumlah yang diminta melebihi stok yang tersedia.');
            }

            Log::info('Stock validation passed', ['product' => $product->toArray()]);

            // Generate nomor pesanan
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total' => $product->harga * $request->quantity,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat
            ]);

            Log::info('Order created', ['order' => $order->toArray()]);

            // Buat order item
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->nama,
                'quantity' => $request->quantity,
                'price' => $product->harga
            ]);

            Log::info('Order item created', ['orderItem' => $orderItem->toArray()]);

            // Kurangi stok
            $product->decrement('stok', $request->quantity);

            // Kirim notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewOrderNotification($order));
            }

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

            $items = collect($data['items'])->map(function ($itemJson) {
                return json_decode($itemJson, true);
            });

            // Validasi semua stok
            foreach ($items as $item) {
                $product = Product::findOrFail($item['id']);
                $this->validateStock($product, $item['quantity']);
            }

            $order = $this->createOrder($data, $data['total']);

            $formattedItems = $items->map(function ($item) {
                $product = Product::findOrFail($item['id']);
                return [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['harga'],
                    'product_name' => $item['nama'],
                ];
            })->toArray();

            $this->createOrderItems($order, $formattedItems);
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

    // ===== 🔧 PRIVATE HELPERS =====

    private function validateStock(Product $product, $quantity)
    {
        if ($quantity > $product->stok) {
            throw new \Exception("Stok produk {$product->nama} tidak mencukupi.");
        }
    }

    private function createOrder(array $data, float $total): Order
    {
        return Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'total' => $total,
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'alamat' => $data['alamat'],
        ]);
    }

    private function createOrderItems(Order $order, array $items)
    {
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product_name'] ?? $item['product']->nama,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            $item['product']->decrement('stok', $item['quantity']);
        }
    }

    private function notifyAdmins(Order $order)
    {
        User::where('role', 'admin')->get()
            ->each(fn($admin) => $admin->notify(new NewOrderNotification($order)));
    }
}
