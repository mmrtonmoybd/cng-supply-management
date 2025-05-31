<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseEntry extends Model
{
    protected $fillable = ['calculation_id', 'description', 'amount', 'date', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function calculation()
    {
        return $this->belongsTo(Calculation::class);
    }
}
