<?php

namespace App\Repositories;

use App\Models\Budget;
 
class BudgetRepository
{
    protected $budget;
    public function __construct()
    {
        $this->budget = new Budget();
    }
    public function getBudgetsByUserId($id, $month)
    {
        return $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->get();
    }
    public function save($budget) 
    {
        $budget->save();
    }
   
}
 