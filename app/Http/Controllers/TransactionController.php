<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transaction;
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function createTransaction(Request $data)
    {
        $this->transactionService->createTransaction($data);
    }
    public function getTransactionsByUserId($id, $month)
    {
        return $this->transactionService->getTransactionsByUserId($id, $month);
    }
    public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id)
    {
        return $this->transactionService->getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id);
    }
}  
 