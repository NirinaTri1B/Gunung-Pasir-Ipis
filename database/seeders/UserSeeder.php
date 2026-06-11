<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'id_user' => 'PL001',
            'nama_user' => 'Petugas Lapangan Glen',
            'email' => 'petugas1@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas_lapangan',
            'no_telp' => '08123456789',
            'alamat' => 'Basecamp Puncak Pasir Ipis'
        ]);
    }
}
