<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BudgetService;


class BudgetController extends Controller
{
  protected $budget;  
  private BudgetService $budgetService;

  public function __construct(BudgetService $budgetService) 
  {
    $this->budgetService = $budgetService;
  }
  public function getBudgetsForHomePage($userID)
  {
    return $this->budgetService->getBudgetsForHomePage($userID);
  }
  public function getDataForBudgetsComponent($userID, $month, $year)
  {
    return $this->budgetService->getDataForBudgetsComponent($userID, $month, $year);
  }
  public function getDataForNewTransaction($userID)
  {
    return $this->budgetService->getDataForNewTransaction($userID); 
  }
  public function getBudgetsForCategoriesComponent($userID)
  {
    return $this->budgetService->getBudgetsForCategoriesComponent($userID);
  }
  public function getCategoriesForAnalytics($userID, $month, $year)
  {
    return $this->budgetService->getCategoriesForAnalytics($userID, $month, $year);
  }
  public function store(Request $data)
  { 
    $this->budgetService->createBudget($data);
  }
  public function update(Request $data, $id)
  {
    $this->budgetService->updateBudget($data, $id);
  }
  public function destroy($id)
  {
    $this->budgetService->deleteBudget($id);
  }
}
