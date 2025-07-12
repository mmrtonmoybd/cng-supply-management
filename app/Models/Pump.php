<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pump extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'payment_date',
        'payment',
        'balance',
        'remarks',
        'load_entry_id',
        'date',
        'vehicle_reg_number',
        'pumpName_id',
        'cng_purchase_m3',
        'rate',
        'purchase_taka',
        'factory_id',
        'cng_pump_id',
        'weight_id',
        'weight_one_id',
        'dispansar_id',
        'diesel_id',
        'third_party_pump_name',
        'new_rate',
        'commission_rate',
    ];

    // protected static $recordEvents = ['updated', 'deleted'];

    protected static function booted(): void
    {
        static::updating(function (Pump $model) {
            if ($model->new_rate) {
                $model->purchase_taka = $model->cng_purchase_m3 * $model->new_rate;
            }
        });
    }

    public function loada()
    {
        return $this->belongsTo(LoadEntry::class, 'load_entry_id', 'id');
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
            ->useLogName('Pumps')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
