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
  public function getBudgetsForHomePage($id)
  {
    return $this->budgetService->getBudgetsForHomePage($id);
  }
  public function getDataForBudgetsComponent($id, $month, $year)
  {
    return $this->budgetService->getDataForBudgetsComponent($id, $month, $year);
  }
  public function getDataForNewTransaction($id)
  {
    return $this->budgetService->getDataForNewTransaction($id);
  }
  public function getBudgetsForCategoriesComponent($id)
  {
    return $this->budgetService->getBudgetsForCategoriesComponent($id);
  }
  public function getCategoriesForAnalytics($id, $month, $year)
  {
    return $this->budgetService->getCategoriesForAnalytics($id, $month, $year);
  }
  public function store(Request $data)
  { 
    $this->budgetService->createBudget($data);
  }
  public function show($id)
  {
    return $this->budgetService->getBudgetById($id);
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
