<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    // protected $fillable = ['user_id', 'nama', 'id_kategori_regu', 'tanggal_lahir', 'foto'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function kategoriRegu()
    {
        return $this->belongsTo(KategoriRegu::class, 'id_kategori_regu');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'user_id');
    }


    public function materi()
    {
        return $this->belongsToMany(Materi::class, 'personel_materi')
            ->withPivot('sudah_mengerjakan', 'skor')
            ->withTimestamps();
    }
}
