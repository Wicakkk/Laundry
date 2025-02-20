<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Super Admin',
            'username' => 'owner',
            'password' => Hash::make('123'),
            'role' => 'owner',
            'id_outlet' => 1
        ]);
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
            'role' => 'admin',
            'id_outlet' => 1
        ]);
        User::create([
            'nama' => 'Mas Amba',
            'username' => 'kasir1',
            'password' => Hash::make('123'),
            'role' => 'kasir',
            'id_outlet' => 1
        ]);
        User::create([
            'nama' => 'Mas Azriel',
            'username' => 'kasir2',
            'password' => Hash::make('123'),
            'role' => 'kasir',
            'id_outlet' => 2
        ]);
        User::create([
            'nama' => 'Mas Ironi',
            'username' => 'kasir3',
            'password' => Hash::make('123'),
            'role' => 'kasir',
            'id_outlet' => 3
        ]);
    }
}
