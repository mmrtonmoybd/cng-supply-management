<?php

// app/Models/Calculation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
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
}
