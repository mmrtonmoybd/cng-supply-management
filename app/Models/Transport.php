<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transport extends Model
{
    use LogsActivity;

    public $fillable = [
        'vehicle_id',
        'date',
        'from',
        'to',
        'rent',
        'maintenance_cost',
        'diesel_cost',
        'toll_cost',
        'labour_cost',
        'chada_cost',
        'fooding_cost',
        'police_cost',
        'parking_cost',
        'other_cost',
        'total_cost',
        'cash_receipt_date',
        'cash_receipt_amount',
        'balance',
        'recived_by',
        'remarks',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    protected static function booted()
    {
        static::saving(function (Transport $model) {
            // Additional logic can be added here if needed after a Transport is created

            $model->total_cost = $model->maintenance_cost + $model->diesel_cost +
                $model->toll_cost + $model->labour_cost + $model->chada_cost +
                $model->fooding_cost + $model->police_cost + $model->parking_cost +
                $model->other_cost;
            $model->total_cost = round($model->total_cost, 2);
            
                $model->balance = $model->cash_receipt_amount - ($model->rent - $model->total_cost);
            
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Transport')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
