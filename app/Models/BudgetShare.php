<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetShare extends Model
{
    use HasFactory;
    public function budgets()
    {
        return $this->belongsTo(Budget::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
