<?php

namespace App\Repositories;

use App\Models\Budget;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class BudgetRepository
{
    protected $budget;
    protected $transaction;
    protected $category;
    protected $currentMonth;
    protected $currentYear;
    public function __construct()
    {
        $this->budget = new Budget();
        $this->transaction = new Transaction();
        $this->category = new Category();
        $this->currentMonth = date('m');
        $this->currentYear = date('Y');
    }
    protected function currentBudgetsWithCategories($userId)
    {
        try {
            $budgets = Budget::with('categories')
                ->where('user_id', '=', $userId)
                ->withSum('categories', 'category_limit')
                ->get();

            return $budgets;
        } catch (\Exception $e) {

            Log::error('Error fetching budgets with categories: ' . $e->getMessage());
            return [];
        }
    }
    protected function getExpensesByBudget($budgets)
    {
        return $budgets->map(function ($budget) {
            return $budget->transactions()
                ->whereMonth('date', $this->currentMonth)
                ->sum('amount') ?? 0;
        })->toArray();
    }
    public function getBudgetsForHomePage($userID)
    {
        $budgets = $this->currentBudgetsWithCategories($userID);
        $homepageData = [
            'budgetNames' => $budgets->pluck('name')->toArray(),
            'expenseSum' => intval($this->transaction->whereMonth('date', $this->currentMonth)->sum('amount')),
            'expensesByBudget' => $this->getExpensesByBudget($budgets),
            'plannedLimit' => $budgets->pluck('categories_sum_category_limit')->toArray(),
        ];
        return $homepageData;
    }
    public function getDataForBudgetsComponent($userID, $month, $year)
    {
        $budgets = $this->currentBudgetsWithCategories($userID);
        $formattedBudgets = $budgets->map(function ($budget) use ($month, $year) {
            $transactionSum = intval(Transaction::where('transactions.budget_id', '=', $budget->id)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount'));
            return [
                'name' => $budget['name'],
                'transactions_sum' => $transactionSum,
                'category_limit_sum' => intval($budget['categories_sum_category_limit']),
            ];
        });
        return $formattedBudgets;
    }
    public function getDataForNewTransaction($userID)
    {
        $budgets = $this->currentBudgetsWithCategories($userID);
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'name' => $budget['name'],
                'categories' => $budget->categories->map(function ($category) {
                    return
                        [
                            'id' => $category['id'],
                            'budget_id' => $category['budget_id'],
                            'category_name' => $category['category_name']
                        ];
                })->toArray(),
            ];
        });
        return $formattedBudgets;
    }
    public function getBudgetsForCategoriesComponent($userID) 
    {
        $budgets = $this->currentBudgetsWithCategories($userID);
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget['id'],
                'name' => $budget['name'],
                'user_id' => $budget['user_id'],
                'categories_sum' => $budget->transactions()
                    ->whereMonth('date', $this->currentMonth)
                    ->sum('amount') ?? 0,
                'categories' => $budget->categories->map(function ($category) {
                    $currentMonth = date('m');
                    $currentYear = date('Y');
                    return array_merge(
                        $category->toArray(),
                        [
                            'transactions_sum' => $category->transactions()->whereMonth('date', $currentMonth)->whereYear('date', $currentYear)->sum('amount')
                        ]
                    );
                })->toArray(),
            ];
        });
        return $formattedBudgets;
    }
    public function getCategoriesForAnalytics($userID, $month, $year)
    {
        $budgets = $this->currentBudgetsWithCategories($userID);
        $formattedBudgets = $budgets->map(function ($budget) use ($month, $year) {
            $categories = $budget->categories->map(function ($category) use ($month, $year) {
                $filteredTransactions = $category->transactions->filter(function ($transaction) use ($month, $year) {
                    $transactionDate = \Carbon\Carbon::parse($transaction->date);
                    return $transactionDate->format('m') == $month && $transactionDate->format('Y') == $year;
                });
                return [
                    'category_name' => $category['category_name'],
                    'transactions_sum' => $filteredTransactions->sum('amount') 
                ];
            });
            return [
                'name' => $budget['name'],
                'labels' => $categories->pluck('category_name'),
                'categories_sum' => $categories->pluck('transactions_sum') 
            ];
        });

        return $formattedBudgets;
    }
    public function save($budget)
    {
        $budget->save();
    }
    public function update($budget)
    {
        $budget->update();
    }
    public function delete($id)
    {
        $budget = $this->budget->findOrFail($id);
        $budget->delete();
    }
}
