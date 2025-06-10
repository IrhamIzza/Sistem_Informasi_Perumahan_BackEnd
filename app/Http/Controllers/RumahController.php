<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\PenghuniRumah;

class RumahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET semua rumah dengan status penghuni saat ini
    public function index()
    {
        $rumah = Rumah::all();
        return response()->json($rumah);
    }

    public function show($id)
    {
        return response()->json(Rumah::findOrFail($id), 200);
    }

    // Tambah rumah
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomer_rumah' => 'required|unique:rumah',
        ]);

        $rumah = Rumah::create([
            'nomer_rumah' => $validated['nomer_rumah'],
            'status_huni' => 'tidak dihuni',
        ]);

        return response()->json($rumah, 201);
    }

    // Ubah rumah
    public function update(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $validated = $request->validate([
            'nomer_rumah' => 'required',
            'status_huni' => 'required'
        ]);

        $rumah->update($validated);

        return response()->json($rumah);
    }

    // Tambah / update penghuni rumah
    public function tambahPenghuni(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $validated = $request->validate([
            'id_penghuni' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        // Tutup relasi lama (jika ada yang aktif)
        PenghuniRumah::where('id_rumah', $id)
            ->whereNull('tanggal_selesai')
            ->update(['tanggal_selesai' => now()]);

        // Tambah relasi baru
        $penghuniRumah = PenghuniRumah::create([
            'id_rumah' => $id,
            'id_penghuni' => $validated['id_penghuni'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
        ]);

        // Update status rumah
        $rumah->update(['status_huni' => 'dihuni']);

        return response()->json($penghuniRumah);
    }

    public function updatePenghuniRumah(Request $request, $id)
    {
        $penghuniRumah = PenghuniRumah::findOrfail($id);

        $validated = $request->validate([
            'id_rumah' => 'required',
            'id_penghuni' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $penghuniRumah->update($validated);

        return response()->json($penghuniRumah);
    }

    // Histori penghuni rumah
    public function historiPenghuni($id)
    {
        $histori = PenghuniRumah::with('penghuni','rumah')
            ->where('id_rumah', $id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return response()->json($histori);
    }

    public function historiPembayaran($id)
    {
        $pembayaran = Pembayaran::with(['iuran', 'penghuni'])
            ->where('id_rumah', $id)
            ->get();

        return response()->json($pembayaran);
    }

    public function getAllPenghuniRumah()
    {
        $rumah = PenghuniRumah::with(['penghuni', 'rumah'])->get();
        return response()->json($rumah);
    }

    public function deletePenghuniRumah($id)
    {
        PenghuniRumah::destroy($id);
        return response()->json(['message' => 'Penghuni Rumah dihapus.'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rumah $rumah, $id)
    {
        Rumah::destroy($id);
        return response()->json(['message' => 'Rumah dihapus.'], 200);
    }
}
