<?php

namespace App\Models;

use App\Models\Boilerplate\User;
use App\Notifications\LoadAddNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LoadEntry extends Model
{
    use LogsActivity;

    protected $fillable = [
        // Add your fillable attributes here, e.g.
        'date',
        'vehicle_reg_number',
        'pumpName_id',
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
            Notification::send($user, new LoadAddNotification($model));

            // Automatically create a Pump entry
            Pump::create(['load_entry_id' => $model->id]);
        });
    }

    public function pump()
    {
        return $this->hasOne(Pump::class);
    }

    public function scopeLocalScopeName($query, $q)
    {
        $query->selectRaw('id as select2_id, CONCAT("Car no: ", vehicle_reg_number, ", Pump name: ", pump_name, " & Date: ", date) as select2_text')
            ->where('vehicle_reg_number', 'like', "$q%")
            ->orWhere('pump_name', 'like', "$q%")
            ->where('status', 0)
            ->orderBy('select2_id', 'ASC');
    }

    public function pumpname()
    {
        return $this->belongsTo(PumpName::class, 'pumpName_id', 'id');
    }
}
