<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Profil Wisata
            ['key' => 'profil_deskripsi', 'label' => 'Deskripsi Profil Wisata', 'grup' => 'profil',
            'value' => 'Gunung Pasir Ipis memiliki ketinggian sekitar 1.307 meter di atas permukaan laut (MDPL)...'],

            // Operasional
            ['key' => 'jam_buka',   'label' => 'Jam Buka',        'grup' => 'operasional', 'value' => '06.00 - 16.30 WIB'],
            ['key' => 'hari_tutup', 'label' => 'Hari Tutup',      'grup' => 'operasional', 'value' => 'Senin & Kamis'],
            ['key' => 'batas_balik','label' => 'Batas Jam Balik', 'grup' => 'operasional', 'value' => '17.00 WIB'],

            // Harga Tiket
            ['key' => 'harga_tektok',  'label' => 'Harga Tektok',  'grup' => 'tiket', 'value' => '15000'],
            ['key' => 'harga_camping', 'label' => 'Harga Camping', 'grup' => 'tiket', 'value' => '30000'],
            ['key' => 'denda_sampah',  'label' => 'Denda Sampah per Item', 'grup' => 'tiket', 'value' => '50000'],

            // Informasi Pendaki
            ['key' => 'info_jalur',   'label' => 'Info Jalur Tracking',    'grup' => 'informasi', 'value' => 'Jalur puncak memiliki medan yang terjal...'],
            ['key' => 'info_camp',    'label' => 'Info Area Camp',         'grup' => 'informasi', 'value' => 'Jarak tempuh sekitar 3.04 km dari basecamp...'],
            ['key' => 'info_sampah',  'label' => 'Info Manajemen Sampah',  'grup' => 'informasi', 'value' => 'Wajib membawa kembali semua sampah bawaan...'],
        ];

        foreach ($data as $item) {
            \App\Models\Konten::create($item);
        }
    }
}
