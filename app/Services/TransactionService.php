<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionService
{
  protected $transactionRepository; 

  public function __construct(TransactionRepository $transactionRepository)
  {
    $this->transactionRepository = $transactionRepository;
  }
  public function getTransactionsByUserId($id, $month)
  {
    return $this->transactionRepository->getTransactionsByUserId($id, $month);
  }
  public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id) 
  {
    return $this->transactionRepository->getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id);
  }
  public function getLastTransactionsByUserId($id)
    {
        return $this->transactionRepository->getLastTransactionsByUserId($id);
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
 