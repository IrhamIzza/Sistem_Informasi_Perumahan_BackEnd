<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenghuniSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('penghuni')->insert([
                'nama' => "Warga Tetap $i",
                'foto_ktp' => "ktp/warga_tetap_$i.jpg",
                'status_penghuni' => 'tetap',
                'nomor_telepon' => '081200000' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status_perkawinan' => $i % 2 == 0 ? 'menikah' : 'belum menikah',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 16; $i <= 20; $i++) {
            DB::table('penghuni')->insert([
                'nama' => "Kontrakan $i",
                'foto_ktp' => "ktp/kontrakan_$i.jpg",
                'status_penghuni' => 'kontrak',
                'nomor_telepon' => '082200000' . $i,
                'status_perkawinan' => $i % 2 == 0 ? 'menikah' : 'belum menikah',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}