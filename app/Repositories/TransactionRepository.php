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
  public function getTransactionsJoinedWithCategoriesByBudgetId($id)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->where('budget_id', '=', $id)->get();
    return $joinedTables;
  }
  public function getTransactionsByUserId($id)
  {
    return $this->transaction->where('user_id', '=', $id)->get();
  }
}
