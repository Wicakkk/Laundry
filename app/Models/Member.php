<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'tb_member';
    protected $fillable = ['nama', 'alamat', 'jenis_kelamin', 'tlp'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_member');
    }
}

