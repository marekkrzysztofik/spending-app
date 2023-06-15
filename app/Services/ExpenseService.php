<?php

namespace App\Services;

use App\Repositories\ExpenseRepository;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseService
{
  protected $expenseRepository;

  public function __construct(ExpenseRepository $expenseRepository)
  {
    $this->expenseRepository = $expenseRepository;
  }
  public function getExpensesJoinedWithCategoriesByMonth($month)
  {
    return $this->expenseRepository->getExpensesJoinedWithCategoriesByMonth($month);
  }
  public function createExpense($data)
  {
    $expense = new Expense;
    $expense->day = $data['day'];
    $expense->month = $data['month'];
    $expense->year = $data['year'];
    $expense->time = $data['time'];
    $expense->category_id = $data['category_id'];
    $expense->price = $data['price'];
    $this->expenseRepository->save($expense);
  }

}
