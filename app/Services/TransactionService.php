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
  public function getTransactionsJoinedWithCategoriesByMonth($month)
  {
    return $this->transactionRepository->getTransactionsJoinedWithCategoriesByMonth($month);
  }
  public function createTransaction($data)
  {
    $transaction = new Transaction;
    $transaction->user_id = $data['user_id'];
    $transaction->category_id = $data['category_id'];
    $transaction->budget_id = $data['budget_id'];
    $transaction->name = $data['name'];
    $transaction->amount = $data['amount'];
    $transaction->date = $data['date'];
    $transaction->type = $data['type'];
    $this->transactionRepository->save($transaction);
  } 

}
