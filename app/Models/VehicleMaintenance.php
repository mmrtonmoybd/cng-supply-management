<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleMaintenance extends Model
{
    use LogsActivity;

    protected $fillable = [
        'vehicle_id',
        'maintenance_cost',
        'details',
        'maintenance_date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Vehicle maintenance')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected static function booted(): void
    {
        static::saving(function (VehicleMaintenance $model) {
            $vehicle = Vehicle::find($model->vehicle_id);
            $vehicle->maintenance_date = $model->maintenance_date;
            $vehicle->save();
        });
    }
}
