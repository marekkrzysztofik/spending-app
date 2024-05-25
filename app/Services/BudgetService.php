<?php

namespace App\Services;

use App\Repositories\BudgetRepository;
use App\Models\Budget;

class BudgetService
{
  protected $budgetRepository;

  public function __construct(BudgetRepository $budgetRepository)
  {
    $this->budgetRepository = $budgetRepository;
  }
  public function getBudgetsForCategoriesComponent($userID)
  { 
    return $this->budgetRepository->getBudgetsForCategoriesComponent($userID);
  }
  public function getDataForNewTransaction($userID)
  {
    return $this->budgetRepository->getDataForNewTransaction($userID);
  }
  public function getDataForBudgetsComponent($userID, $month, $year) 
  {
    return $this->budgetRepository->getDataForBudgetsComponent($userID, $month, $year);
  }
  public function getBudgetsForHomePage($userID)
  {
    return $this->budgetRepository->getBudgetsForHomePage($userID);
  }
  public function getCategoriesForAnalytics($userID, $month, $year)
  {
    return $this->budgetRepository->getCategoriesForAnalytics($userID, $month, $year);
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
    $this->budgetRepository->update($budget);
  }
}
