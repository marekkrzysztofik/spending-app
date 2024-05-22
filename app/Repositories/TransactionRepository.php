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
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($userID, $month, $year)
  {
    $joinedTables = DB::table('categories')
      ->join('transactions', 'categories.id', '=', 'transactions.category_id')->join('budgets', 'categories.budget_id', '=', 'budgets.id')->where('budgets.user_id', '=', $userID)->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->get();
    return $joinedTables;
  }
  public function getLastTransactionsByUserId($userId)
  {
    $transactions = Transaction::where('user_id', $userId)
      ->orderByDesc('id')
      ->take(10)
      ->get();

    $categoryIds = $transactions->pluck('category_id')->unique()->toArray();
    $categories = Category::whereIn('id', $categoryIds)->pluck('category_name', 'id');

    $formattedTransactions = $transactions->map(function ($transaction) use ($categories) {
      $categoryName = $categories[$transaction->category_id] ?? 'Unknown';
      return [
        'title' => $transaction->title,
        'date' => $transaction->date,
        'amount' => $transaction->amount,
        'category_name' => $categoryName,
      ];
    });
    return $formattedTransactions->toArray();
  }
}
