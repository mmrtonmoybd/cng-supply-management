<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Dispansar extends Model
{
    use LogsActivity;

    protected $fillable = [
        'load_entry_id',
        'bill_no',
        'bill_date',
        'opening_reading',
        'closing_reading',
        'total_reading',
        'rate',
        'bill_amount',
        'difference_m3',
        'difference_taka',
        'in',
        'out',
        'cash_receipt_date',
        'cash_receipt_amount',
        'balance',
        'recived_by',
        'remarks',
        'date',
        'vehicle_reg_number',
        'pumpName_id',
        'factory_id',
        'cng_purchase_m3',
        'lrate',
        'purchase_taka',
        'invoice_id',
        'invoice_date',
    ];

    protected static function booted(): void
    {
        static::created(function (Dispansar $model) {
            if (! $model->load_entry_id) {
                Pump::create([
                    'dispansar_id' => $model->id,
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

        static::updated(function (Dispansar $model) {
            if (! $model->load_entry_id) {
                Pump::updateOrCreate(['dispansar_id' => $model->id], [
                    'dispansar_id' => $model->id,
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
                $sum = Dispansar::where('invoice_id', $model->invoice_id)->sum('bill_amount');
                $invoice = Invoice::find($model->invoice_id);
                if ($invoice) {
                    $invoice->update(['total' => $sum]);
                }
            }
        });

        static::saved(function (Dispansar $model) {
            if ($model->load_entry_id) {
                VehicleIncome::updateOrCreate([
                    'load_entry_id' => $model->load_entry_id,
                ],
                    [
                        'dispansar_id' => $model->id,
                        'bill_date' => $model->bill_date ?? $model->date,
                        'fm3' => $model->total_reading,
                        'rate' => $model->rate,
                        'ftk' => $model->bill_amount,
                    ]);

            }
        });
    }

    public function loada()
    {
        return $this->belongsTo(LoadEntry::class, 'load_entry_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Factory Dispansar')
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
}
