<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction; 

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
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->join('budgets', 'categories.budget_id', '=', 'budgets.id')->select('transactions.id','budgets.name','categories.category_name','transactions.title','transactions.date','transactions.amount')->where('budgets.user_id', '=', $id)->orderBy('transactions.id')->get();
    return $joinedTables;
  }
  public function getTransactionsByUserId($id, $month)
  {
    return $this->transaction->where('user_id', '=', $id)->whereMonth('date', '=', $month)->get(); 
  }
}
