<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = ['personel_id', 'materi_id', 'number', 'durasi', 'unique_id'];

    public function personel()
    {
        return $this->belongsTo(Personel::class,'personel_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class,'materi_id'); 
    }
}

