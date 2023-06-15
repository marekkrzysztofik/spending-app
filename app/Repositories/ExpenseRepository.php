<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Expense;

class ExpenseRepository
{
  protected $expense;
  public function __construct()
  {
    $this->expense = new Expense();
  }

  public function save($expense)
  {
    $expense->save();
  }
  public function getExpensesJoinedWithCategoriesByMonth($month)
  {
    // return $this->expense->where('month', '=', $month)->get();
    $joinedTables = DB::table('categories')
      ->join('expenses', 'categories.id', '=', 'expenses.category_id')->where('month', '=', $month)->get();
    return $joinedTables;
  }
}
