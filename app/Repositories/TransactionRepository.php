<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Category;
use Carbon\Carbon;

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
    $currentMonth = date('m');
    $currentYear = date('Y');
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->join('budgets', 'categories.budget_id', '=', 'budgets.id')->where('budgets.user_id', '=', $id)->whereMonth('date', '=', $currentMonth)->whereYear('date', '=', $currentYear)->get();
    return $joinedTables;
  }
  public function getTransactionsByUserId($id, $month)
  {
    return $this->transaction->where('user_id', '=', $id)->whereMonth('date', '=', $month)->get();
  }
  public function getLastTransactionsByUserId($id)
  {
    $transactions = Transaction::where('user_id', '=', $id)->get();
    $formattedTransactions = $transactions->map(function ($transaction){
      $catName = Category::where('categories.id', '=', $transaction->category_id)->value('categories.category_name');
      return [
        'title' => $transaction['title'],
        'date' => $transaction['date'],
        'amount' => $transaction['amount'],
        'category_name' => $catName,
      ];
    });
    return $formattedTransactions;
  }
  public function getDataForHomePage($id)
  {
    $currentYear = date('Y');
    $transactions = $this->transaction->where('user_id', '=', $id)->whereYear('date', '=', $currentYear)->get();
    $result = [
      'months' => [],
      'values' => [],
    ];
    for ($month = 1; $month <= 12; $month++) {
      $result['months'][] = Carbon::create(null, $month)->format('m');
      $result['values'][] = 0;
    }
    foreach ($transactions as $transaction) {
      $monthYear = Carbon::parse($transaction->date)->format('m');
      $result['values'][array_search($monthYear, $result['months'])] += $transaction->amount;
    }
    return $result['values'];
  }
}
 