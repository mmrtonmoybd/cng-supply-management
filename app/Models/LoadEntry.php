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
        'factory_id',
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
            // $user = User::whereIn('id', getRolePermissionUsersId('admin', 'load_crud'))->get();
            // Use Notification facade to notify all users at once
            // Notification::send($user, new LoadAddNotification($model));

            // Automatically create a Pump entry
            Pump::create([
                'load_entry_id' => $model->id,
                'purchase_taka' => $model->purchase_taka,
                'rate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);
        });

        static::updating(function (LoadEntry $model) {
            Pump::where('load_entry_id', $model->id)->update([
                'purchase_taka' => $model->purchase_taka,
                'rate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);

            Dispansar::where('load_entry_id', $model->id)->update([
                'purchase_taka' => $model->purchase_taka,
                'lrate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);

            CngPump::where('load_entry_id', $model->id)->update([
                'purchase_taka' => $model->purchase_taka,
                'lrate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);

            Weight::where('load_entry_id', $model->id)->update([
                'purchase_taka' => $model->purchase_taka,
                'lrate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);

            WeightOne::where('load_entry_id', $model->id)->update([
                'purchase_taka' => $model->purchase_taka,
                'lrate' => $model->rate,
                'date' => $model->date,
                'vehicle_reg_number' => $model->vehicle_reg_number,
                'pumpName_id' => $model->pumpName_id,
                'cng_purchase_m3' => $model->cng_purchase_m3,
                'factory_id' => $model->factory_id,
            ]);

        });

        static::saved(function (LoadEntry $model) {
            VehicleIncome::updateOrCreate([
                'load_entry_id' => $model->id,
            ],
                [
                    'load_entry_id' => $model->id,
                    'date' => $model->date,
                    'vehicle_reg_number' => $model->vehicle_reg_number,
                    'pumpName_id' => $model->pumpName_id,
                    'factory_id' => $model->factory_id,
                    'cng_purchase_m3' => $model->cng_purchase_m3,
                    'lrate' => $model->rate,
                    'purchase_taka' => $model->purchase_taka,
                ]);
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

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function highlight()
    {
        return $this->hasMany(Highlight::class, 'module_id', 'id')->where('module_name', 'loadEntry');
    }
}
