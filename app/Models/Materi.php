<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'video',
        'kategori_materi_id',
        'kategori_kelas_id',
        'thumbnail',
        'images',
        'no_sertif',
        'pernyataan_sertifikat',
        'keterangan_sertifikat',
        'foto_tanda_tangan',
        'start_date',
        'end_date'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMateri::class, 'kategori_materi_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KategoriKelas::class, 'kategori_kelas_id');
    }

    public function regus()
    {
        return $this->belongsToMany(KategoriRegu::class, 'materi_regu');
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function personels()
    {
        return $this->belongsToMany(Personel::class, 'personel_materi')
            ->withPivot('sudah_mengerjakan', 'skor')
            ->withTimestamps();
    }
}
