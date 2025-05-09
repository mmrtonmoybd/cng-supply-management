<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadEntry extends Model
{
    protected $fillable = [
        // Add your fillable attributes here, e.g.
        'date',
        'vehicle_reg_number',
        'pump_name',
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
}
