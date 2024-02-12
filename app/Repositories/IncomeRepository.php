<?php

namespace App\Repositories;

use App\Models\Income;
   
class IncomeRepository
{
    protected $income;
    public function __construct()
    {
        $this->income = new Income();
    }
    public function getIncomesByUserId($id, $month)
    {
        return $this->income->where('user_id', '=', $id)->whereMonth('date', '=', $month)->get();
        
    }
    public function save($income) 
    {
        $income->save();
    }
}
  