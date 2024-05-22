<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Models\Transaction;

class TransactionService
{
  protected $transactionRepository;

  public function __construct(TransactionRepository $transactionRepository)
  {
    $this->transactionRepository = $transactionRepository;
  }
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($userID, $month, $year)
  {
    return $this->transactionRepository->getTransactionsJoinedWithCategoriesAndBudgetsByUserId($userID, $month, $year);
  }
  public function getLastTransactionsByUserId($userID)
  {
    return $this->transactionRepository->getLastTransactionsByUserId($userID);
  }
  public function createTransaction($data)
  {
    $transaction = new Transaction;
    $transaction->user_id = $data['user_id'];
    $transaction->budget_id = $data['budget_id'];
    $transaction->category_id = $data['category_id'];
    $transaction->title = $data['title'];
    $transaction->amount = $data['amount'];
    $transaction->date = $data['date'];
    $this->transactionRepository->save($transaction);
  }
}
