<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Data untuk cards
            $totalUsers = User::count();
            $totalOrders = Order::count();
            $totalProducts = Product::count();

            // Data penjualan bulanan (6 bulan terakhir)
            $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

            // Format data bulanan untuk Chart.js
            $monthlyLabels = [];
            $monthlyData = [];
            foreach ($monthlySales as $sale) {
                $date = Carbon::createFromDate($sale->year, $sale->month, 1);
                $monthlyLabels[] = $date->format('M Y');
                $monthlyData[] = $sale->total_sales;
            }

            // Data penjualan mingguan (7 hari terakhir)
            $weeklySales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

            // Format data mingguan untuk Chart.js
            $weeklyLabels = [];
            $weeklyData = [];
            foreach ($weeklySales as $sale) {
                $date = Carbon::parse($sale->date);
                $weeklyLabels[] = $date->format('D');
                $weeklyData[] = $sale->total_sales;
            }

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalOrders',
                'totalProducts',
                'monthlyLabels',
                'monthlyData',
                'weeklyLabels',
                'weeklyData'
            ));
        }

        // Jika bukan admin, arahkan ke halaman katalog
        return redirect()->route('ecatalog.index');
    }
}
