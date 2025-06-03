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
use App\Models\Cart;
use App\Models\User;
use App\Notifications\NewOrderNotification;

class CheckoutController extends Controller
{
    /**
     * Tampilkan form checkout dengan data produk dari query parameter.
     */
    public function show(Request $request)
    {
        $productId = $request->query('product_id');
        $product = null;
        
        if ($productId) {
            $product = Product::findOrFail($productId);
            return view('ecatalog.checkout', [
                'product' => $product,
                'productId' => $productId,
                'productName' => $product->nama,
                'price' => $product->harga
            ]);
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan');
    }

    /**
     * Proses submit pesanan.
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

            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->user_name = $request->user_name;
            $order->email = $request->email;
            $order->alamat = $request->alamat;
            $order->telepon = $request->telepon;
            $order->status = 'pending';
            $order->save();

            // Get product
            $product = Product::findOrFail($request->product_id);
            
            if ($product->stok < 1) {
                throw new \Exception('Stok produk tidak mencukupi');
            }

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
     * Halaman status pesanan.
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
