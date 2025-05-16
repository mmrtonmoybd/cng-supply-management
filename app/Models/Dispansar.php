<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispansar extends Model
{
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
    ];

    public function loada()
    {
        return $this->belongsTo(LoadEntry::class, 'load_entry_id', 'id');
    }
}
