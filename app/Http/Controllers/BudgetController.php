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
    public function store(Request $data)
    {
      $this->budgetService->createBudget($data);
    }
    public function show($id,$month)
    {
      return $this->budgetService->getBudgetsByUserId($id, $month);
    }
    public function update(Request $data, $id)
    {
      $this->budgetService->updateBudget($data, $id);
    }
    public function getBudgetById($id)
    {
      return $this->budgetService->getBudgetById($id);
    }
}
