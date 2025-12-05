<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['nama_link', 'materi_id', 'deskripsi_link', 'link'];

    public function materi()
    {
        return $this->belongsTo(Materi::class,'materi_id');
    }
}

