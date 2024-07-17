<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemenData = [
            [
                'nama_departemen' => 'Departemen IT',
                'nama_pembimbing' => 'Andri Susanto',
                'user' => [
                    'role' => 'departemen',
                    'name' => 'Andri Susanto',
                    'nomor_induk' => 'DEPIT',
                    'alamat' => 'Jl. Slamet Riyadi 1',
                    'email' => 'andri@gmail.com',
                    'asal_kampus' => '',
                    'password' => 'andri',
                    'status' => 'aktif',
                    'no_telpon' => '081234567891',
                    'departemen_id' => '1',
                ],
            ],
            [
                'nama_departemen' => 'Departemen K3',
                'nama_pembimbing' => 'Dwi Kurniawan',
                'user' => [
                    'role' => 'departemen',
                    'name' => 'Dwi Kurniawan',
                    'nomor_induk' => 'DEP002',
                    'alamat' => 'Jl. Slamet Riyadi 2',
                    'email' => 'dwi.kurniawan@gmail.com',
                    'asal_kampus' => '',
                    'password' => 'dwi',
                    'status' => 'aktif',
                    'no_telpon' => '081234567892',
                    'departemen' => 'KOM',
                ],
            ],
        ];

        foreach ($departemenData as $data) {
            $userId = DB::table('users')->insertGetId([
                'role' => $data['user']['role'],
                'name' => $data['user']['name'],
                'nomor_induk' => $data['user']['nomor_induk'],
                'alamat' => $data['user']['alamat'],
                'email' => $data['user']['email'],
                'asal_kampus' => $data['user']['asal_kampus'],
                'password' => Hash::make($data['user']['password']),
                'status' => $data['user']['status'],
                'no_telpon' => $data['user']['no_telpon'],
                'departemen' => $data['user']['departemen'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('departemen')->insert([
                'nama_departemen' => $data['nama_departemen'],
                'nama_pembimbing' => $data['nama_pembimbing'],
                'user_id' => $userId,
                'status' => 'aktif',
            ]);
        }
    }
}
