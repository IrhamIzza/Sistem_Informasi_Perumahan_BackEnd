<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $status = 'dihuni';

        for ($i = 1; $i <= 20; $i++) {
            if ($i >= 16) {
                $status = 'tidak dihuni';
            }
            DB::table('rumah')->insert([
                'nomer_rumah' => 'A' . $i, // Bisa diganti dengan format lain
                'status_huni' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
