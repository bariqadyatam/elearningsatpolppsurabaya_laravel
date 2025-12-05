<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['test_id', 'durasi', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban'];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
