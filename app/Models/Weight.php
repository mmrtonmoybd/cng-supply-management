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
        'pump_name',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Weight Scale')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
