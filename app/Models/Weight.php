<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Weight extends Model
{
    use LogsActivity;

    protected $fillable = [
        'load_entry_id',
        'date',
        'vehicle_reg_number',
        'pumpName_id',
        'factory_id',
        'cng_purchase_m3',
        'lrate',
        'purchase_taka',
        'bill_no',
        'bill_date',
        'first_weight',
        'second_weight',
        'total_weight',
        'fact',
        'receive_m3',
        'rate',
        'ftk',
        'total_bill_no',
        'total_bill_taka',
        'difference_taka',
        'difference_m3',
        'in',
        'out',
        'cash_receipt_date',
        'cash_receipt_amount',
        'balance',
        'recived_by',
        'remarks',
        'bill_amount',
    ];

    protected static function booted(): void
    {
        static::created(function (Weight $model) {
            if (! $model->load_entry_id) {
                Pump::create([
                    'weight_id' => $model->id,
                    'purchase_taka' => $model->purchase_taka,
                    'rate' => $model->rate,
                    'date' => $model->date,
                    'vehicle_reg_number' => $model->vehicle_reg_number,
                    'pumpName_id' => $model->pumpName_id,
                    'cng_purchase_m3' => $model->cng_purchase_m3,
                    'factory_id' => $model->factory_id,
                ]);
            }

        });

        static::updated(function (Weight $model) {
            if (! $model->load_entry_id) {
                Pump::updateOrCreate(['weight_id' => $model->id], [
                    'weight_id' => $model->id,
                    'purchase_taka' => $model->purchase_taka,
                    'rate' => $model->rate,
                    'date' => $model->date,
                    'vehicle_reg_number' => $model->vehicle_reg_number,
                    'pumpName_id' => $model->pumpName_id,
                    'cng_purchase_m3' => $model->cng_purchase_m3,
                    'factory_id' => $model->factory_id,
                ]);
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Factory Weight Scale')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function pumpname()
    {
        return $this->belongsTo(PumpName::class, 'pumpName_id', 'id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function loada()
    {
        return $this->belongsTo(LoadEntry::class, 'load_entry_id', 'id');
    }
}
