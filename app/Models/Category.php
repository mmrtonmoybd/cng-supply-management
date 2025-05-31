<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function income() {
        return $this->hasMany(IncomeEntry::class);
    }

    public function expense() {
        return $this->hasMany(ExpenseEntry::class);
    }
}
