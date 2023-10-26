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
    public function createBudget(Request $data)
    {
        $this->budgetService->createBudget($data);
    }
    public function getBudgetsByUserId($id, $month)
  {
    return $this->budgetService->getBudgetsByUserId($id, $month);
  }
}
