<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rawilk\Settings\Facades\Settings;

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
        'remark',
    ];

    public function pumpname()
    {
        return $this->belongsTo(PumpName::class, 'pumpName_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            // Calculate use_litre and use_balance before saving
            $factor_liter = Settings::get('factor_liter');
            $factor_balance = Settings::get('factor_balance');

            if (! is_null($model->distance)) {
                $devide = $model->distance / $factor_liter;

                $model->use_litre = $devide;

                $model->use_balance = $devide * $factor_balance;
            }

        });
    }
}
