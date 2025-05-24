<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return view('ecatalog.status', ['orders' => collect(), 'message' => 'Masukkan email untuk melihat pesanan']);
        }

        $orders = Order::where('email', $email)->latest()->get();

        return view('ecatalog.status', compact('orders', 'email'));
    }
}

