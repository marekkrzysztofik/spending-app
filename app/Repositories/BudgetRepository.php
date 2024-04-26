<?php

namespace App\Repositories;

use App\Models\Budget;
use App\Models\Transaction;
use App\Models\Category;

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
    protected function currentBudgetsWithCategories($id)
    {
        $budgets = Budget::with('categories')->where('budgets.user_id', '=', $id)->withSum('categories', 'category_limit')
            ->get();
        return $budgets;
    }

    public function getBudgetsForHomePage($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $currentMonth = $this->currentMonth;
        $homepageData = [
            'budgetNames' => $budgets->pluck('name')->toArray(),
            'expenseSum' => intval($this->transaction->whereMonth('date', $this->currentMonth)->sum('amount')),
            'expensesByBudget' => $budgets->map(function ($budget) use ($currentMonth) {
                return $budget->transactions()
                    ->whereMonth('date', $currentMonth)
                    ->sum('amount') ?? 0;
            })->toArray(),
            'plannedLimit' => $budgets->pluck('categories_sum_category_limit')->toArray(),
        ];
        return $homepageData;
    }
    public function getDataForBudgetsComponent($id, $month, $year)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $formattedBudgets = $budgets->map(function ($budget) use ($month, $year) {
            $transaction = intval(Transaction::where('transactions.budget_id', '=', $budget->id)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount'));
            $categoryLimitSum = intval($budget['categories_sum_category_limit']);
            return [
                'name' => $budget['name'],
                'limit' => $budget['limit'],
                'transactions_sum' => $transaction,
                'category_limit_sum' => $categoryLimitSum,

                'labels' => ['Planned', 'Spent',],
                'datasets' => [
                    [
                        'data' => [$categoryLimitSum, $transaction,],
                        'backgroundColor' => ['#41B883', '#E46651',],
                    ]
                ],
            ];
        });
        return $formattedBudgets;
    }
    public function getDataForNewTransaction($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
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
    public function getBudgetsForCategoriesComponent($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget['id'],
                'name' => $budget['name'],
                'user_id' => $budget['user_id'],
                'categories_sum' => $budget['transactions_sum_amount'],
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
    public function getCategoriesForAnalytics($id, $month, $year)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget['id'],
                'name' => $budget['name'],
                'user_id' => $budget['user_id'],
                'start_date' => $budget['start_date'],
                'limit' => $budget['limit'],
                'labels' => $budget->categories->map(function ($category) {
                    return
                        $category['category_name'];
                }),
                'categories_sum' => $budget->categories->map(function ($category) {
                    return
                        $category->transactions->sum('amount');
                }),
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
