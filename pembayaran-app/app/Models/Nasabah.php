<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nasabah extends Model
{
    protected $table = 'nasabah';

    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'alamat',
    ];

    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
}
