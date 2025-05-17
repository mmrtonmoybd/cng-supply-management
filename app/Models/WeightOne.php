<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightOne extends Model
{
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
        'fm3',
        'rate',
        'ftk',
        'difference_taka',
        'first_weight',
        'second_weight',
        'total_weight',
        'bill_amount',
        'cash_receipt_date',
        'cash_receipt_amount',
        'balance',
        'recived_by',
        'remarks',
    ];
}
