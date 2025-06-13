<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleIncome extends Model
{
    use LogsActivity;
    protected $fillable = [
        'load_entry_id',
        'dispansar_id',
        'weight_one_id',
        'weight_id',
        'cng_pump_id',
        'date',
        'vehicle_reg_number',
        'pumpName_id',
        'factory_id',
        'cng_purchase_m3',
        'lrate',
        'purchase_taka',
        'bill_date',
        'fm3',
        'rate',
        'ftk',
        'difference', 
        'rent',
        'driver_fooding',
        'maintenance',
        'other',
    ];

    protected static function booted(): void {
        static::saving(function (VehicleIncome $model) {
    if (!is_null($model->purchase_taka) && !is_null($model->ftk)) {
        $model->difference = $model->ftk - $model->purchase_taka;
    }
});
    }

    public function pumpname()
    {
        return $this->belongsTo(PumpName::class, 'pumpName_id', 'id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Vehicle income')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
