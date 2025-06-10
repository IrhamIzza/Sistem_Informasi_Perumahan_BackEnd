<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IuranSeeder extends Seeder
{
    public function run()
    {
        DB::table('iuran')->insert([
            ['nama' => 'Satpam', 'nominal' => 100000, 'berlaku_mulai' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kebersihan', 'nominal' => 15000, 'berlaku_mulai' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
