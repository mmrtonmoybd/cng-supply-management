<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'type', // e.g., 'vehicle', 'equipment', etc.
        'vehicle_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Asset')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
