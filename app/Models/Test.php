<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['materi_id', 'nama_test'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function personelMateri()
    {
        return $this->hasMany(PersonelMateri::class, 'test_id');
    }
}
