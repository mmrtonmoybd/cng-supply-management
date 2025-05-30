<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use LogsActivity;

    protected $fillable = [
        'factory_type',
        'factory_id',
        'date',
        'total',
        'hash',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Invoice')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            // Automatically generate a unique hash for the invoice
            $invoice->hash = md5(uniqid(rand(), true));
        });
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function dispansar()
    {
        return $this->hasMany(Dispansar::class, 'invoice_id', 'id');
    }

    public function cngpump()
    {
        return $this->hasMany(CngPump::class, 'invoice_id', 'id');
    }

    public function weight()
    {
        return $this->hasMany(Weight::class, 'invoice_id', 'id');
    }

    public function weightone()
    {
        return $this->hasMany(WeightOne::class, 'invoice_id', 'id');
    }
}
