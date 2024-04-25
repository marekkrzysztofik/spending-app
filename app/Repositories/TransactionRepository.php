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
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id, $currentMonth, $currentYear)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->join('budgets', 'categories.budget_id', '=', 'budgets.id')->where('budgets.user_id', '=', $id)->whereMonth('date', '=', $currentMonth)->whereYear('date', '=', $currentYear)->get();
    return $joinedTables;
  }
  public function getLastTransactionsByUserId($id)
  {
    $transactions = Transaction::where('user_id', '=', $id)->orderBy('id', 'desc')->take(10)->get();
    $formattedTransactions = $transactions->map(function ($transaction) {
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
}
