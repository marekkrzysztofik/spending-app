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
    ];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
} 
