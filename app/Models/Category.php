<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'budget_id',
        'category_name',
        'category_limit',
    ];
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
 