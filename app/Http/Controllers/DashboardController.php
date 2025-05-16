<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika ingin mengecek role admin
        // if (Auth::user()->role !== 'admin') {
        //     abort(403, 'Akses ditolak.');
        // }
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        return view('dashboard', compact('totalUsers', 'totalOrders', 'totalProducts'));
    }
}
