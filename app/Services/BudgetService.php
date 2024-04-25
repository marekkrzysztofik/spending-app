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
  public function getBudgetsForCategoriesComponent($id)
  {
    return $this->budgetRepository->getBudgetsForCategoriesComponent($id);
  }
  public function getDataForNewTransaction($id)
  {
    return $this->budgetRepository->getDataForNewTransaction($id);
  }
  public function getDataForBudgetsComponent($id, $month, $year) 
  {
    return $this->budgetRepository->getDataForBudgetsComponent($id, $month, $year);
  }
  public function getBudgetsForHomePage($id)
  {
    return $this->budgetRepository->getBudgetsForHomePage($id);
  }
  public function getCategoriesForAnalytics($id, $month, $year)
  {
    return $this->budgetRepository->getCategoriesForAnalytics($id, $month, $year);
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
