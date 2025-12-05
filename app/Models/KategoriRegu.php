<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriRegu extends Model
{
    protected $fillable = [
        'kategori_kelas_id',
        'nama',
        'keterangan'
    ];


    public function materi()
    {
        return $this->belongsToMany(Materi::class, 'materi_regu');
    }

    public function personels()
    {
        return $this->hasMany(Personel::class, 'id_kategori_regu');
    }

    public function kelas()
    {
        return $this->belongsTo(KategoriKelas::class, 'kategori_kelas_id', 'id');
    }
}
