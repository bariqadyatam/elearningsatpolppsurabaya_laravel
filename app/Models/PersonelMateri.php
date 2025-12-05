<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonelMateri extends Pivot
{
    protected $table = 'personel_materi';

    protected $fillable = [
        'personel_id',
        'test_id',
        'sudah_mengerjakan',
        'skor',
    ];

    public $timestamps = true; // jika tabel menyertakan kolom created_at dan updated_at

    // Relasi ke model Personel
    public function personel()
    {
        return $this->belongsTo(Personel::class);
    }

    // Relasi ke model Materi
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
