<?php
namespace App\Http\Controllers;

use App\Models\Penghuni;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // Tampilkan semua penghuni
    public function index()
    {
        return response()->json(Penghuni::all(), 200);
    }

    // Simpan penghuni baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'foto_ktp' => 'nullable|image|max:2048',
            'status_penghuni' => 'required|in:tetap,kontrak',
            'nomor_telepon' => 'required|string',
            'status_perkawinan' => 'required|in:menikah,belum menikah',
        ]);

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni = Penghuni::create($validated);

        return response()->json($penghuni, 201);
    }

    // Update data penghuni
    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'foto_ktp' => 'nullable|image|max:2048',
            'status_penghuni' => 'sometimes|in:tetap,kontrak',
            'nomor_telepon' => 'sometimes|string',
            'status_perkawinan' => 'sometimes|in:menikah,belum menikah',
        ]);

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni->update($validated);

        return response()->json($penghuni, 200);
    }

    // Detail satu penghuni
    public function show($id)
    {
        return response()->json(Penghuni::findOrFail($id), 200);
    }

    // Hapus penghuni
    public function destroy($id)
    {
        Penghuni::destroy($id);
        return response()->json(['message' => 'Penghuni dihapus.'], 200);
    }
}
