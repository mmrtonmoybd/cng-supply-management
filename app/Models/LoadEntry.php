<?php

namespace App\Models;

use App\Notifications\LoadAddNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Sebastienheyd\Boilerplate\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LoadEntry extends Model
{
    use LogsActivity;

    protected $fillable = [
        // Add your fillable attributes here, e.g.
        'date',
        'vehicle_reg_number',
        'pump_name',
        'cng_purchase_m3',
        'rate',
        'purchase_taka',
        'fuel_cost',
        'fuel_pump',
        'factory_name',
        'status',
        'remark',
        'diesel_litter',
        'diesel_rate',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Load')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected static function booted(): void
    {
        static::created(function (LoadEntry $model) {
            $user = User::whereIn('id', getRolePermissionUsersId('admin', 'load_index'))->get();
            // Use Notification facade to notify all users at once
            Notification::send($user, new LoadAddNotification($model, auth()->user()));

            // Automatically create a Pump entry
            Pump::create(['load_entry_id' => $model->id]);
        });
    }

    public function pump()
    {
        return $this->hasOne(Pump::class);
    }
}
