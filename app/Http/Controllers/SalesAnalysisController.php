<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::select(
                DB::raw('DATE(sale_date) as tanggal'),
                DB::raw('SUM(price * quantity) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Hitung total pendapatan
        $totalRevenue = $sales->sum('total');

        return view('admin.sales-analysis', compact('sales', 'totalRevenue'));
    }

}
