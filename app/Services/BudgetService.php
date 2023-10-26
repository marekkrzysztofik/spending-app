<?php

namespace App\Services;

use App\Repositories\BudgetRepository;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetService
{
  protected $budgetRepository;

  public function __construct(BudgetRepository $budgetRepository)
  {
    $this->budgetRepository = $budgetRepository;
  }
  public function getBudgetsByUserId($id, $month)
  {
    return $this->budgetRepository->getBudgetsByUserId($id, $month);
  }
  public function createBudget($data)
  {
    $budget = new Budget;
    $budget->user_id = $data['user_id'];
    $budget->name = $data['name'];
    $budget->description = $data['description'];
    $budget->start_date = $data['start_date'];
    $budget->end_date = $data['end_date'];
    $budget->limit = $data['limit'];
    $this->budgetRepository->save($budget);
  }
}
