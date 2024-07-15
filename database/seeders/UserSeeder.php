<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role' => 'admin',
                'name' => 'Administrator',
                'nomor_induk' => 'ADM001',
                'alamat' => 'Jl. Slamet Riyadi',
                'email' => 'admin@gmail.com',
                'asal_kampus' => 'PDAM-Tirta Mayang',
                'password' => bcrypt('admin'),
                'status' => 'aktif',
                'no_telpon' => '081234567890',
                'departemen' => 'SDM',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
