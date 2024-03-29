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
    protected function currentBudgetsWithCategories($id, $currentMonth = null, $currentYear = null)
    {
        $budgets = Budget::with('categories')->where('user_id', '=', $id)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get();
        return $budgets;
    }
    public function getBudgetsForHomePage($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id)->toArray();
        $chartData = [
            'labels' => array_column($budgets, 'name'),
            'expenseSum' => array_sum(array_column($budgets, 'transactions_sum_amount')),
            'datasets' => [
                [
                    'label' => 'Wydane',
                    'backgroundColor' => ['#41B883'],
                    'data' => array_column($budgets, 'transactions_sum_amount')
                ],
                [
                    'label' => 'Zaplanowane',
                    'backgroundColor' => ['#E46651'],
                    'data' => array_column($budgets, 'limit')
                ]
            ]
        ];
        return $chartData;
    }
    public function getDataForBudgetsComponent($id, $month, $year)
    {
        $budgets = $this->currentBudgetsWithCategories($id, $month, $year);
        $formattedBudgets = $budgets->map(function ($budget) {
            $transactionsSum = intval($budget['transactions_sum_amount']);
            $categoryLimitSum = intval($budget['categories_sum_category_limit']);
            return [
                'name' => $budget['name'],
                'limit' => $budget['limit'],
                'transactions_sum' => $transactionsSum,
                'category_limit_sum' => $categoryLimitSum,
                'labels' => ['Spent', 'Planned'],
                'datasets' => [
                    [
                        'data' => [$transactionsSum, $categoryLimitSum],
                        'backgroundColor' => ['#E46651', '#41B883'],
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
                'start_date' => $budget['start_date'],
                'limit' => $budget['limit'],
                'categories_sum' => $budget['transactions_sum_amount'],
                'categories' => $budget->categories->map(function ($category) {
                    return array_merge(
                        $category->toArray(),
                        [
                            'transactions_sum' => $category->transactions->sum('amount')
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
    // public function getBudgetsByUserId($id, $month, $year)
    // {
    //     return $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get(); 
    // }
    public function getBudgetById($id)
    {
        return $this->budget->find($id);
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
