<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
    protected $fillable = [
        'vehicle_id',
        'name',
        'issued_date',
        'expiry_date',
        'path',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function getDocumentUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
