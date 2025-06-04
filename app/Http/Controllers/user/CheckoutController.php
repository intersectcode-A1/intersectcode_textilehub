<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;

class CheckoutController extends Controller
{
    /**
     * Tampilkan form checkout untuk pembelian langsung.
     */
    public function showDirect($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Buat array items seperti format cart untuk menggunakan view yang sama
            $items = [[
                'id' => $product->id,
                'nama' => $product->nama,
                'harga' => $product->harga,
                'quantity' => 1,
                'subtotal' => $product->harga
            ]];
            
            $total = $product->harga;

            return view('ecatalog.checkout-cart', [
                'items' => $items,
                'total' => $total,
                'is_direct' => true
            ]);
        } catch (\Exception $e) {
            return redirect()->route('ecatalog.index')->with('error', 'Produk tidak ditemukan');
        }
    }

    /**
     * Tampilkan form checkout untuk single product.
     */
    public function show(Request $request)
    {
        $productId = $request->query('product_id');
        
        if (!$productId) {
            return redirect()->route('ecatalog.index')->with('error', 'Produk tidak ditemukan');
        }

        $product = Product::findOrFail($productId);
        return view('ecatalog.checkout', compact('product'));
    }

    /**
     * Proses submit pesanan untuk single product.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            
            if ($product->stok < 1) {
                throw new \Exception('Stok produk tidak mencukupi');
            }

            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->user_name = $request->user_name;
            $order->email = $request->email;
            $order->alamat = $request->alamat;
            $order->telepon = $request->telepon;
            $order->total = $product->harga;
            $order->status = 'pending';
            $order->save();

            // Create order item
            $orderItem = new OrderItem([
                'product_id' => $product->id,
                'product_name' => $product->nama,
                'quantity' => 1,
                'price' => $product->harga
            ]);
            
            $order->items()->save($orderItem);

            // Update stock
            $product->stok -= 1;
            $product->save();

            // Send notification to admin
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewOrderNotification($order));

            DB::commit();

            return redirect()->route('order.status')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Proses submit pesanan dari cart.
     */
    public function submitFromCart(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'items' => 'required|array',
            'total' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->user_name = $request->user_name;
            $order->email = $request->email;
            $order->alamat = $request->alamat;
            $order->telepon = $request->telepon;
            $order->total = $request->total;
            $order->status = 'pending';
            $order->save();

            // Process each item
            foreach ($request->items as $itemData) {
                $item = json_decode($itemData, true);
                $product = Product::findOrFail($item['id']);
                
                if ($product->stok < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk produk {$product->nama}");
                }

                // Create order item
                $orderItem = new OrderItem([
                    'product_id' => $product->id,
                    'product_name' => $product->nama,
                    'quantity' => $item['quantity'],
                    'price' => $product->harga
                ]);
                
                $order->items()->save($orderItem);

                // Update stock
                $product->stok -= $item['quantity'];
                $product->save();
            }

            // Clear cart session
            session()->forget('cart');

            // Send notification to admin
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewOrderNotification($order));

            DB::commit();

            return redirect()->route('order.status')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan status pesanan.
     */
    public function status()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with('items.product')
                      ->latest()
                      ->paginate(10);

        return view('ecatalog.status', compact('orders'));
    }

    /**
     * Detail status pesanan.
     */
    public function statusDetail($id)
    {
        $order = Order::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->with('items.product')
                     ->firstOrFail();

        return view('ecatalog.statusdetail', compact('order'));
    }

    /**
     * Membatalkan pesanan
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->with('items')
                         ->firstOrFail();

            if ($order->status === 'pending') {
                // Return stock for each item
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stok += $item->quantity;
                        $product->save();
                    }
                }

                $order->status = 'cancelled';
                $order->save();

                DB::commit();
                return redirect()->route('order.status')->with('success', 'Pesanan berhasil dibatalkan.');
            }

            DB::rollBack();
            return redirect()->route('order.status')->with('error', 'Pesanan tidak dapat dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('order.status')->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }
}
