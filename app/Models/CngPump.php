<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CngPump extends Model
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
        'fm3',
        'rate',
        'ftk',
        'difference_taka',
        'difference_m3',
        'in',
        'out',
        'cash_receipt_date',
        'cash_receipt_amount',
        'balance',
        'recived_by',
        'remarks',
        'invoice_id',
        'invoice_date',
    ];

    protected static function booted(): void
    {
        static::created(function (CngPump $model) {
            if (! $model->load_entry_id) {
                Pump::create([
                    'cng_pump_id' => $model->id,
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

        static::updated(function (CngPump $model) {
            if (! $model->load_entry_id) {
                Pump::updateOrCreate(['cng_pump_id' => $model->id], [
                    'cng_pump_id' => $model->id,
                    'purchase_taka' => $model->purchase_taka,
                    'rate' => $model->rate,
                    'date' => $model->date,
                    'vehicle_reg_number' => $model->vehicle_reg_number,
                    'pumpName_id' => $model->pumpName_id,
                    'cng_purchase_m3' => $model->cng_purchase_m3,
                    'factory_id' => $model->factory_id,
                ]);
            }

            if ($model->invoice_id) {
                $sum = CngPump::where('invoice_id', $model->invoice_id)->sum('ftk');
                $invoice = Invoice::find($model->invoice_id);
                if ($invoice) {
                    $invoice->update(['total' => $sum]);
                }
            }
        });

        static::saved(function (CngPump $model) {
            if ($model->load_entry_id) {
                VehicleIncome::updateOrCreate([
                'load_entry_id' => $model->load_entry_id,
            ], 
            [
                'cng_pump_id' => $model->id,
                'bill_date' => $model->bill_date ?? $model->date,
                'fm3' => $model->fm3,
                'rate' => $model->rate,
                'ftk' => $model->ftk,
            ]);

            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Factory CNG Pump Slip')
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
