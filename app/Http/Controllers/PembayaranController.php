<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('pembayaran')
            ->join('rumah', 'pembayaran.id_rumah', '=', 'rumah.id')
            ->join('iuran', 'pembayaran.id_iuran', '=', 'iuran.id')
            ->select(
                'rumah.nomer_rumah',
                'rumah.status_huni',
                'iuran.nama as jenis_iuran',
                'iuran.nominal',
                'pembayaran.id as id_pembayaran',
                'pembayaran.periode_bulan',
                'pembayaran.periode_tahun',
                'pembayaran.status_lunas'
            )
            ->orderBy('rumah.id')
            ->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rumah' => 'required|exists:rumah,id',
            'id_iuran' => 'required|exists:iuran,id',
            'mulai_bulan' => 'required|integer|min:1|max:12',
            'mulai_tahun' => 'required|integer|min:2020',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
        ]);

        $bulan = $request->mulai_bulan;
        $tahun = $request->mulai_tahun;

        for ($i = 0; $i < $request->jumlah_bulan; $i++) {
            $periodeBulan = $bulan + $i;
            $periodeTahun = $tahun;

            if ($periodeBulan > 12) {
                $periodeBulan = $periodeBulan % 12;
                $periodeTahun += 1;
            }

            $pembayaran = Pembayaran::create([
                'id_rumah' => $request->id_rumah,
                'id_iuran' => $request->id_iuran,
                'periode_bulan' => $periodeBulan,
                'periode_tahun' => $periodeTahun,
                'tanggal_bayar' => now(),
                'status_lunas' => 'lunas'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran berhasil dicatat',
            'data' => $pembayaran,
        ]);
    }

    public function riwayatRumah($id_rumah)
    {
        $data = Pembayaran::with('penghuni')
            ->where('id_rumah', $id_rumah)
            ->orderByDesc('periode_tahun')
            ->orderByDesc('periode_bulan')
            ->get();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function updateStatus($id, Request $request)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $pembayaran->status_lunas = 'lunas';
        $pembayaran->tanggal_bayar = now();
        $pembayaran->save();

        return response()->json(['message' => 'Status pembayaran berhasil diubah menjadi lunas.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
