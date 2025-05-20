<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PumpName extends Model
{
    protected $fillable = [
        'name',
        'type',
        'address',
        'email',
        'phone',
    ];

    public function loada()
    {
        return $this->hasMany(LoadEntry::class);
    }
}
