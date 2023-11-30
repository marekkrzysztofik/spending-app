<?php

namespace App\Http\Controllers;

use App\Models\Budget;
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
  public function index()
  {
    return $this->budgetService->getBudgetsWithCategories();
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
  public function getBudgetsByUserId($id, $month)
  {
    return $this->budgetService->getBudgetsByUserId($id, $month);
  }
  public function destroy($id)
  {
    $this->budgetService->deleteBudget($id);
  }
}
