<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenghuniRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('penghuni_rumah')->insert([
                'id_penghuni' => $i,
                'id_rumah' => $i,
                'tanggal_mulai' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addYears(1)->format('Y-m-d'),
            ]);
        }
    }
}
