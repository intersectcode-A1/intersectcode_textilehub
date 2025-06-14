<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LaporanKeuanganController extends Controller
{
    public function index()
    {
        return view('admin.laporan_keuangan.index', ['laporan' => null]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        try {
            $laporan = DB::table('transaksis')
                ->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir])
                ->orderBy('tanggal')
                ->get();

            return view('laporan.index', [
                'laporan' => $laporan,
                'mulai' => $request->tanggal_mulai,
                'akhir' => $request->tanggal_akhir,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
}
