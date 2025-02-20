<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_user'; 

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'id_outlet'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet', 'id');
    }
}
