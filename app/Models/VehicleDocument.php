<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleDocument extends Model
{
    use LogsActivity;

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
        return asset('storage/'.$this->path);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Vehicle document')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
