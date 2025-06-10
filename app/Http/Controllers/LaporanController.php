<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pembayaran;
use App\Models\SaldoBulanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function grafikTahunan(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;

        // Ambil data dari tabel saldo_bulanan
        $data = SaldoBulanan::where('tahun', $tahun)
            ->orderBy('bulan')
            ->get(['bulan', 'total_pemasukan', 'total_pengeluaran', 'saldo_akhir']);

        // Pastikan 12 bulan tetap tersedia meski belum ada transaksi
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);

            $item = $data->firstWhere('bulan', $i);

            $result[] = [
                'bulan' => $bulan,
                'total_pemasukan' => $item->total_pemasukan ?? 0,
                'total_pengeluaran' => $item->total_pengeluaran ?? 0,
                'saldo_akhir' => $item->saldo_akhir ?? 0,
            ];
        }

        return response()->json($result);
    }

    public function detailBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pemasukan = Pembayaran::with('penghuni', 'iuran')
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->get();

        $pengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return response()->json([
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ]);
    }

    public function historyPembayaran(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $iurans = DB::table('iuran')->get()->keyBy('nama');

        $penghuniRumah = DB::table('penghuni_rumah')
            ->join('penghuni', 'penghuni.id', '=', 'penghuni_rumah.id_penghuni')
            ->join('rumah', 'rumah.id', '=', 'penghuni_rumah.id_rumah')
            ->select('penghuni_rumah.*', 'penghuni.nama as nama_penghuni', 'penghuni.status_penghuni', 'rumah.nomer_rumah')
            ->get();

        $periode = Carbon::createFromDate($tahun, $bulan, 1);

        $hasil = [];

        foreach ($penghuniRumah as $pr) {
            $mulai = Carbon::parse($pr->tanggal_mulai);
            $selesai = Carbon::parse($pr->tanggal_selesai);

            // Hanya jika penghuni aktif di bulan tersebut
            if (!$periode->between($mulai, $selesai)) continue;

            $row = [
                'rumah' => $pr->nomer_rumah,
                'penghuni' => $pr->nama_penghuni,
                'status_penghuni' => $pr->status_penghuni,
                'periode' => str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun,
                'satpam' => 'belum',
                'kebersihan' => 'belum',
                'total_tagihan' => 0
            ];

            foreach (['Satpam', 'Kebersihan'] as $iuranNama) {
                $iuranId = $iurans[$iuranNama]->id;
                $nominal = $iurans[$iuranNama]->nominal;

                $cek = DB::table('pembayaran')
                    ->where('id_penghuni', $pr->id_penghuni)
                    ->where('id_rumah', $pr->id_rumah)
                    ->where('id_iuran', $iuranId)
                    ->where('periode_bulan', $bulan)
                    ->where('periode_tahun', $tahun)
                    ->first();

                if ($cek && $cek->status_lunas == 'lunas') {
                    $row[strtolower($iuranNama)] = 'lunas';
                }

                $row['total_tagihan'] += $nominal;
            }

            $hasil[] = $row;
        }

        return response()->json($hasil);
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
