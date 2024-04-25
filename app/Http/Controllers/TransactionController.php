<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function createTransaction(Request $data)
    {
        $this->transactionService->createTransaction($data);
    }
    public function getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id, $currentMonth, $currentYear)
    {
        return $this->transactionService->getTransactionsJoinedWithCategoriesAndBudgetsByUserId($id, $currentMonth, $currentYear);
    }
    public function getLastTransactionsByUserId($id)
    {
        return $this->transactionService->getLastTransactionsByUserId($id);
    }
}
