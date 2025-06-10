<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Iuran Tetap
        DB::table('iuran')->insert([
            [
                'nama' => 'Satpam',
                'nominal' => 100000,
                'berlaku_mulai' => '2024-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kebersihan',
                'nominal' => 15000,
                'berlaku_mulai' => '2024-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. 20 Rumah
        for ($i = 1; $i <= 20; $i++) {
            DB::table('rumah')->insert([
                'nomer_rumah' => 'Blok ' . chr(64 + ceil($i / 5)) . $i,
                'status_huni' => $i <= 15 ? 'dihuni' : 'tidak dihuni',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. 15 Penghuni Tetap + 5 Kontrak
        for ($i = 1; $i <= 15; $i++) {
            DB::table('penghuni')->insert([
                'nama' => 'Warga Tetap ' . $i,
                'foto_ktp' => 'ktp/warga_tetap_' . $i . '.jpg',
                'status_penghuni' => 'tetap',
                'nomor_telepon' => '081200000' . $i,
                'status_perkawinan' => $i % 2 == 0 ? 'menikah' : 'belum menikah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 16; $i <= 20; $i++) {
            DB::table('penghuni')->insert([
                'nama' => 'Kontrakan ' . $i,
                'foto_ktp' => 'ktp/kontrakan_' . $i . '.jpg',
                'status_penghuni' => 'kontrak',
                'nomor_telepon' => '082200000' . $i,
                'status_perkawinan' => $i % 2 == 0 ? 'menikah' : 'belum menikah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Penghuni Rumah (relasi)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('penghuni_rumah')->insert([
                'id_penghuni' => $i,
                'id_rumah' => $i,
                'tanggal_mulai' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addYears(1)->format('Y-m-d'),
            ]);
        }

        // 5. Pengeluaran rutin & tidak rutin
        DB::table('pengeluaran')->insert([
            [
                'nama' => 'Gaji Satpam',
                'tanggal' => now()->format('Y-m-01'),
                'nominal' => 1000000,
                'keterangan' => 'Gaji bulanan satpam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perbaikan Jalan',
                'tanggal' => now()->subMonths(2)->format('Y-m-d'),
                'nominal' => 2500000,
                'keterangan' => 'Betonisasi gang utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Token Listrik Pos Satpam',
                'tanggal' => now()->format('Y-m-d'),
                'nominal' => 300000,
                'keterangan' => 'Token listrik bulanan pos satpam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}

