<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'tb_outlet';
    protected $fillable = ['nama', 'alamat', 'tlp'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_outlet');
    }

    public function pakets()
    {
        return $this->hasMany(Paket::class, 'id_outlet');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_outlet');
    }
}
