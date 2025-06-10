<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PenghuniRumah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
    // }
    public function run(): void
    {
        $this->call([
            PenghuniSeeder::class,
            RumahSeeder::class,
            IuranSeeder::class,
            PenghuniRumahSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
