<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Jika admin, tampilkan dashboard admin
            $totalUsers = User::count();
            $totalOrders = Order::count();
            $totalProducts = Product::count();

            return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'totalProducts'));
        }

        // Jika bukan admin, arahkan ke halaman katalog
        return redirect()->route('ecatalog.index');
    }
}
