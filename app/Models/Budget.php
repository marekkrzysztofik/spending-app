<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'limit',
    ];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function budgetShares()
    {
        return $this->hasMany(BudgetShare::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
} 
