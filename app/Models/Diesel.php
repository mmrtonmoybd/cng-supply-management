<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rawilk\Settings\Facades\Settings;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Diesel extends Model
{
    use LogsActivity;

    protected $fillable = [
        'd_date',
        'd_time',
        'slip_no',
        'pumpName_id',
        'vehicle_reg_number',
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

            if (is_null($model->d_date)) {
                $model->d_date = $model->date;
            }

        });

        static::saved(function ($model) {
            // Move Pump update here
            if ($model->taka && $model->pumpname && $model->pumpname->is_diesel == 1) {
                Pump::updateOrCreate([
                    'diesel_id' => $model->id,
                ], [
                    'diesel_id' => $model->id,
                    'purchase_taka' => 0,
                    'rate' => 0,
                    'cng_purchase_m3' => 0,
                    'pumpName_id' => $model->pumpName_id,
                    'vehicle_reg_number' => $model->vehicle_reg_number,
                    'date' => $model->d_date,
                ]);
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Diesel')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function highlight() {
        return $this->hasMany(Highlight::class, 'module_id', 'id')->where('module_name', 'diesel');
    }
}
