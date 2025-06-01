<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diesel extends Model
{
    protected $fillable = [
        'd_date',
        'd_time',
        'slip_no',
        'pumpName_id',
        'vehicle_id',
        'diesel_purchase_litre',
        'taka',
        'date',
        'time',
        'distance',
        'use_litre',
        'use_balance',
        'remark'
    ];

    public function pumpname()
    {
        return $this->belongsTo(PumpName::class, 'pumpName_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
