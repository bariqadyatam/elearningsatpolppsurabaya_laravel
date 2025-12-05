<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMateri extends Model
{
    use HasFactory;

    protected $table = 'kategori_materis';

    protected $fillable = [
        'nama',
        'keterangan'
    ];

    // Relasi ke materi
    public function materis()
    {
        return $this->hasMany(Materi::class, 'kategori_materi_id');
    }
}
