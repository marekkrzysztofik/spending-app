<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    protected $expense;
    private ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    public function createExpense(Request $data)
    {
        $this->expenseService->createExpense($data);
    }
    public function getExpensesJoinedWithCategoriesByMonth($month)
    {
        return $this->expenseService->getExpensesJoinedWithCategoriesByMonth($month);
    }

} 
