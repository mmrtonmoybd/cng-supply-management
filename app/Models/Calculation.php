<?php

// app/Models/Calculation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Calculation extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'date', 'previous_balance', 'balance'];

    public function incomeEntries()
    {
        return $this->hasMany(IncomeEntry::class);
    }

    public function expenseEntries()
    {
        return $this->hasMany(ExpenseEntry::class);
    }

    public function getCurrentBalance($previousBalance = 0)
    {
        return $previousBalance + $this->balance;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Cashbook')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
