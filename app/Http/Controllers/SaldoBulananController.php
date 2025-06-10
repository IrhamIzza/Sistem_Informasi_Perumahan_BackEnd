<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SaldoBulananController extends Controller
{

    public function storeMonthlySummary()
    {
        $today = now();
        $bulan = $today->month;
        $tahun = $today->year;

        // Hitung pemasukan dari pembayaran lunas pada bulan ini
        $totalPemasukan = DB::table('pembayaran')
            ->join('iuran', 'pembayaran.id_iuran', '=', 'iuran.id')
            ->where('pembayaran.status_lunas', 'lunas')
            ->whereMonth('pembayaran.tanggal_bayar', $bulan)
            ->whereYear('pembayaran.tanggal_bayar', $tahun)
            ->sum('iuran.nominal');

        // Hitung pengeluaran dari tabel pengeluaran berdasarkan bulan dan tahun
        $totalPengeluaran = DB::table('pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        // Cek apakah entri saldo sudah ada
        $existing = DB::table('saldo_bulanan')->where('bulan', $bulan)->where('tahun', $tahun)->first();

        if ($existing) {
            DB::table('saldo_bulanan')->where('id', $existing->id)->update([
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'saldo_akhir' => $totalPemasukan - $totalPengeluaran,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('saldo_bulanan')->insert([
                'bulan' => $bulan,
                'tahun' => $tahun,
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'saldo_akhir' => $totalPemasukan - $totalPengeluaran,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Rekap saldo bulanan berhasil diperbarui.',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran
        ]);
    }
}
