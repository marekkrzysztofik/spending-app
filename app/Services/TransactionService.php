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
  public function getTransactionsByCategoryId($id)
  {
    return $this->transactionRepository->getTransactionsByCategoryId($id);
  }
  public function createTransaction($data)
  {
    $transaction = new Transaction;
    $transaction->category_id = $data['category_id'];
    $transaction->title = $data['title'];
    $transaction->amount = $data['amount'];
    $transaction->type = $data['type'];
    $transaction->date = $data['date'];
    $this->transactionRepository->save($transaction);
  } 

}
