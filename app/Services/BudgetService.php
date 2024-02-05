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
  public function getBudgetsWithCategoriesWithTransactionsSum($id)
  {
    return $this->budgetRepository->getBudgetsWithCategoriesWithTransactionsSum($id);
  }
  public function getBudgetsWithCategories($id)
  {
    return $this->budgetRepository->getBudgetsWithCategories($id);
  }
  public function getBudgetById($id)
  {
    return $this->budgetRepository->getBudgetById($id);
  }
  public function getBudgetsByUserId($id, $month,$year)
  {
    return $this->budgetRepository->getBudgetsByUserId($id, $month,$year);
  }
  public function deleteBudget($id)
  {
    return $this->budgetRepository->delete($id);
  }
  public function createBudget($data)
  {
    $budget = new Budget;
    $budget->user_id = $data['user_id'];
    $budget->name = $data['name'];
    $budget->shared = $data['shared']; 
    $budget->start_date = $data['start_date'];
    $budget->end_date = $data['end_date'];
    $budget->limit = $data['limit'];
    $this->budgetRepository->save($budget); 
  }
  public function updateBudget($data, $id)
  {
    $budget = Budget::find($id);
    $budget->name = $data['name'];
    $budget->limit = $data['limit'];
    $this->budgetRepository->update($budget); 
  }
}
