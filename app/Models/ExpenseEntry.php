<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ExpenseEntry extends Model
{
    use LogsActivity;
    protected $fillable = ['calculation_id', 'description', 'amount', 'date', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function calculation()
    {
        return $this->belongsTo(Calculation::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Expense entry')
            ->logExcept(['created_at', 'updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
