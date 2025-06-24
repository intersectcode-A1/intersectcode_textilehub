<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        // Default periode 30 hari jika tidak ada request
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(30);

        return $this->getLaporanData($startDate, $endDate);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid',
            'tanggal_akhir.required' => 'Tanggal akhir harus diisi',
            'tanggal_akhir.date' => 'Format tanggal akhir tidak valid',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir harus sama dengan atau setelah tanggal mulai'
        ]);

        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_akhir);

        return $this->getLaporanData($startDate, $endDate);
    }

    private function getLaporanData($startDate, $endDate)
    {
        try {
            // Data transaksi keuangan
            $laporan = DB::table('transaksis')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal')
                ->get();

            // Hitung total pendapatan dan pengeluaran
            $totalPendapatan = $laporan->where('jumlah', '>', 0)->sum('jumlah');
            $totalPengeluaran = abs($laporan->where('jumlah', '<', 0)->sum('jumlah'));
            $saldo = $totalPendapatan - $totalPengeluaran;

            // Data untuk grafik pendapatan dan pengeluaran
            $dataGrafik = DB::table('transaksis')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(tanggal) as tanggal'),
                    DB::raw('SUM(CASE WHEN jumlah > 0 THEN jumlah ELSE 0 END) as pendapatan'),
                    DB::raw('SUM(CASE WHEN jumlah < 0 THEN ABS(jumlah) ELSE 0 END) as pengeluaran')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $labelsGrafik = $dataGrafik->map(function($item) {
                return Carbon::parse($item->tanggal)->format('d M');
            });
            $dataPendapatan = $dataGrafik->pluck('pendapatan');
            $dataPengeluaran = $dataGrafik->pluck('pengeluaran');

            // Data untuk ringkasan periode
            $periodeSebelumnya = [
                'start' => $startDate->copy()->subDays($endDate->diffInDays($startDate)),
                'end' => $startDate->copy()->subDay()
            ];

            $laporanSebelumnya = DB::table('transaksis')
                ->whereBetween('tanggal', [$periodeSebelumnya['start'], $periodeSebelumnya['end']])
                ->get();

            $totalPendapatanSebelumnya = $laporanSebelumnya->where('jumlah', '>', 0)->sum('jumlah');
            $totalPengeluaranSebelumnya = abs($laporanSebelumnya->where('jumlah', '<', 0)->sum('jumlah'));
            $saldoSebelumnya = $totalPendapatanSebelumnya - $totalPengeluaranSebelumnya;

            // Hitung persentase perubahan
            $persentasePendapatan = $this->hitungPersentasePerubahan($totalPendapatan, $totalPendapatanSebelumnya);
            $persentasePengeluaran = $this->hitungPersentasePerubahan($totalPengeluaran, $totalPengeluaranSebelumnya);
            $persentaseSaldo = $this->hitungPersentasePerubahan($saldo, $saldoSebelumnya);

            return view('admin.laporan_keuangan.index', [
                'laporan' => $laporan,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
                'totalPendapatan' => $totalPendapatan,
                'totalPengeluaran' => $totalPengeluaran,
                'saldo' => $saldo,
                'persentasePendapatan' => $persentasePendapatan,
                'persentasePengeluaran' => $persentasePengeluaran,
                'persentaseSaldo' => $persentaseSaldo,
                'labelsGrafik' => $labelsGrafik,
                'dataPendapatan' => $dataPendapatan,
                'dataPengeluaran' => $dataPengeluaran
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    private function hitungPersentasePerubahan($nilaiSekarang, $nilaiSebelumnya)
    {
        if ($nilaiSebelumnya == 0) {
            return $nilaiSekarang > 0 ? 100 : 0;
        }
        return (($nilaiSekarang - $nilaiSebelumnya) / $nilaiSebelumnya) * 100;
    }
}
