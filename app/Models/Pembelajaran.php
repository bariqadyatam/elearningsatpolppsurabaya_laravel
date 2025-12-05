<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    protected $table = 'pembelajarans';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    public function personel()
    {
        return $this->hasMany(Personel::class, 'personel_id', 'id');
    }
}
