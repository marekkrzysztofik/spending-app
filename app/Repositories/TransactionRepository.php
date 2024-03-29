<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction; 
use App\Models\Category; 

class TransactionRepository
{
  protected $transaction;
  public function __construct()
  { 
    $this->transaction = new Transaction();
  }
 
  public function save($transaction)
  { 
    $transaction->save(); 
  }
  // public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id)
  // {
  //   $joinedTables = Category::with('transactions')->get();
  //   return $joinedTables;
  // }
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->join('budgets', 'categories.budget_id', '=', 'budgets.id')->where('budgets.user_id', '=', $id)->get();
    return $joinedTables;
  }
  public function getTransactionsByUserId($id, $month)
  {
    return $this->transaction->where('user_id', '=', $id)->whereMonth('date', '=', $month)->get(); 
  }
  public function getLastTransactionsByUserId($id)
    {
      return $this->transaction->where('user_id', '=', $id)->orderBy('id', 'desc')->take(10)->get();
    }
}
