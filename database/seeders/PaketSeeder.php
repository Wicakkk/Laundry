<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = DB::table('tb_outlet')->pluck('id');

        $pakets = [
            ['jenis' => 'kiloan', 'nama_paket' => 'Cuci Kering Kiloan', 'harga' => 8000],
            ['jenis' => 'kiloan', 'nama_paket' => 'Cuci Setrika Kiloan', 'harga' => 12000],
            ['jenis' => 'bed_cover', 'nama_paket' => 'Bed Cover Single', 'harga' => 25000],
            ['jenis' => 'bed_cover', 'nama_paket' => 'Bed Cover King Size', 'harga' => 40000],
            ['jenis' => 'selimut', 'nama_paket' => 'Selimut Bulu', 'harga' => 30000],
            ['jenis' => 'kaos', 'nama_paket' => 'Cuci Kaos', 'harga' => 5000],
            ['jenis' => 'lain', 'nama_paket' => 'Cuci Kemeja', 'harga' => 7000],
            ['jenis' => 'lain', 'nama_paket' => 'Dry Clean Jas', 'harga' => 50000],
            ['jenis' => 'lain', 'nama_paket' => 'Paket Kebaya', 'harga' => 45000],
            ['jenis' => 'kiloan', 'nama_paket' => 'Express 6 Jam', 'harga' => 20000],
            ['jenis' => 'kiloan', 'nama_paket' => 'Express 3 Jam', 'harga' => 30000],
        ];

        foreach ($outlets as $outlet) {
            foreach ($pakets as $paket) {
                DB::table('tb_paket')->insert([
                    'id_outlet'   => $outlet,
                    'jenis'       => $paket['jenis'],
                    'nama_paket'  => $paket['nama_paket'],
                    'harga'       => $paket['harga'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
