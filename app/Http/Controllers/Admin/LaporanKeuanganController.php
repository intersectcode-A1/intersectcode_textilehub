<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
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
            $laporan = DB::table('transaksis')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal')
                ->get();

            $currentSummary = $this->getTransaksiSummary($laporan);

            $dataGrafik = $this->getGrafikData($startDate, $endDate);
            $labelsGrafik = $dataGrafik->map(fn($item) => Carbon::parse($item->tanggal)->format('d M'));
            $dataPendapatan = $dataGrafik->pluck('pendapatan');
            $dataPengeluaran = $dataGrafik->pluck('pengeluaran');

            // Periode sebelumnya
            $periodeSebelumnya = [
                'start' => $startDate->copy()->subDays($endDate->diffInDays($startDate)),
                'end' => $startDate->copy()->subDay()
            ];

            $laporanSebelumnya = DB::table('transaksis')
                ->whereBetween('tanggal', [$periodeSebelumnya['start'], $periodeSebelumnya['end']])
                ->get();

            $previousSummary = $this->getTransaksiSummary($laporanSebelumnya);

            return view('admin.laporan_keuangan.index', [
                'laporan' => $laporan,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
                'totalPendapatan' => $currentSummary['pendapatan'],
                'totalPengeluaran' => $currentSummary['pengeluaran'],
                'saldo' => $currentSummary['saldo'],
                'persentasePendapatan' => $this->hitungPersentasePerubahan($currentSummary['pendapatan'], $previousSummary['pendapatan']),
                'persentasePengeluaran' => $this->hitungPersentasePerubahan($currentSummary['pengeluaran'], $previousSummary['pengeluaran']),
                'persentaseSaldo' => $this->hitungPersentasePerubahan($currentSummary['saldo'], $previousSummary['saldo']),
                'labelsGrafik' => $labelsGrafik,
                'dataPendapatan' => $dataPendapatan,
                'dataPengeluaran' => $dataPengeluaran,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    private function getTransaksiSummary($laporan)
    {
        $pendapatan = $laporan->where('jumlah', '>', 0)->sum('jumlah');
        $pengeluaran = abs($laporan->where('jumlah', '<', 0)->sum('jumlah'));
        $saldo = $pendapatan - $pengeluaran;

        return compact('pendapatan', 'pengeluaran', 'saldo');
    }

    private function getGrafikData($startDate, $endDate)
    {
        return DB::table('transaksis')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(CASE WHEN jumlah > 0 THEN jumlah ELSE 0 END) as pendapatan'),
                DB::raw('SUM(CASE WHEN jumlah < 0 THEN ABS(jumlah) ELSE 0 END) as pengeluaran')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    private function hitungPersentasePerubahan($sekarang, $sebelumnya)
    {
        if ($sebelumnya == 0) {
            return $sekarang > 0 ? 100 : 0;
        }

        return (($sekarang - $sebelumnya) / $sebelumnya) * 100;
    }
}
