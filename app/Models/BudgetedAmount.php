<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetedAmount extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'amount',
        'date',
    ];
}
