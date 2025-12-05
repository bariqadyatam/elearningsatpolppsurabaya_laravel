<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKelas extends Model
{
    protected $table = 'kategori_kelas';

    protected $guarded = [];

    // app/Models/KategoriKelas.php
    public function kategoriRegus()
    {
        return $this->hasMany(KategoriRegu::class, 'kategori_kelas_id');
    }

    public function materis()
    {
        return $this->hasMany(Materi::class, 'kategori_kelas_id');
    }
}
