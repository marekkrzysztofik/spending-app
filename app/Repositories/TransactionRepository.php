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
  public function getTransactionsJoinedWithCategoriesByMonth($month)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->whereMonth('date', '=', $month)->get();
    return $joinedTables;
  }
}
