<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Factory extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'type',
        'address',
        'email',
        'phone',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Factory names')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function cngpump() {
        return $this->hasMany(CngPump::class, 'factory_id');
    }

    public function dispansar() {
        return $this->hasMany(Dispansar::class, 'factory_id');
    }

    public function weight() {
        return $this->hasMany(Weight::class, 'factory_id');
    }

    public function weightone() {
        return $this->hasMany(WeightOne::class, 'factory_id');
    }
}
