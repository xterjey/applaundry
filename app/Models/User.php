<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user';

    protected $fillable = [
        'nama', 'username', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function outlet()
    {
        return $this->belongsToMany(Outlet::class, 'outlet_user', 'id_outlet', 'id_user');
    }

    public function user()
    {
        return $this->hasMany(Transaksi::class);
    }
}
