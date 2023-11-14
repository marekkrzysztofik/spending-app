<?php

namespace App\Services; 

use App\Repositories\IncomeRepository;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeService
{
  protected $incomeRepository;

  public function __construct(IncomeRepository $incomeRepository)
  {
    $this->incomeRepository = $incomeRepository;
  }
  public function getIncomesByUserId($id, $month)
  {
    return $this->incomeRepository->getIncomes($id, $month);
  }
  public function createIncome($data)
  {
    $income = new Income;
    $income->user_id = $data['user_id'];
    $income->title = $data['title'];
    $income->date = $data['date'];
    $income->amount = $data['amount'];
    $this->incomeRepository->save($income); 
  }
}
