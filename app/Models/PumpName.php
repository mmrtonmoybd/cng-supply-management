<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PumpName extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'type',
        'address',
        'email',
        'phone',
        'is_diesel',
    ];

    public function loada()
    {
        return $this->hasMany(LoadEntry::class);
    }

    public function diesel()
    {
        return $this->hasMany(Diesel::class, 'pumpName_id');
    }

    public function pump()
    {
        return $this->hasMany(Pump::class, 'pumpName_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Pump names')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
