<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;
use Illuminate\Support\Facades\DB;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            [
                'nama' => 'Laundry Mas Amba',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'tlp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Laundry Mas Azriel',
                'alamat' => 'Jl. Thamrin No. 45, Bandung',
                'tlp' => '082233445566',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Laundry Mas Ironi',
                'alamat' => 'Jl. Merdeka No. 67, Surabaya',
                'tlp' => '083344556677',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tb_outlet')->insert($outlets);
    }
}
