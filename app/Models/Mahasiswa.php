<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['uid', 'nama', 'nim'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
