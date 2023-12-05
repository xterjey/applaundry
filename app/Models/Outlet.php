<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'tb_outlet';
    protected $guarded = [];

    protected $fillable = [
        'nama', 'alamat', 'tlp',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'outlet_user', 'id_outlet', 'id_user');
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class, 'id_outlet');
    }
}
