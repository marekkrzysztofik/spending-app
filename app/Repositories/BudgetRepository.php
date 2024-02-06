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
    public function __construct()
    {
        $this->budget = new Budget();
        $this->transaction = new Transaction();
        $this->category = new Category();
    }
    protected function currentBudgetsWithCategories($id)
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $budgets = Budget::with('categories')->where('user_id', '=', $id)->whereMonth('start_date', '=', $currentMonth)->whereYear('start_date', '=', $currentYear)->get();
        return $budgets;
    }
    public function getBudgetsWithCategories($id)
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
    public function getBudgetsWithCategoriesWithTransactionsSum($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget['id'],
                'name' => $budget['name'],
                'user_id' => $budget['user_id'],
                'start_date' => $budget['start_date'],
                'limit' => $budget['limit'],
                'categories_sum' => $this->transaction->sum('amount'),
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
    // public function getBudgetsByUserId($id, $month, $year)
    // {
    //     return $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get(); 
    // }
    public function getBudgetsByUserId($id, $month, $year)
    {
        $budgets = $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get(); 
        $formattedBudgets = $budgets->map(function ($budget) {
            $transactionsSum = $budget['transactions_sum_amount'];
            return [
                'name' => $budget['name'],               
                'limit' => $budget['limit'],
                'transactions_sum' => $transactionsSum,
                'labels' => ['Spent','Planned'],
                'datasets' => [[
                    'data'=> [$transactionsSum, $budget['limit']],
                    'backgroundColor' => ['#E46651', '#41B883'],
                ]
                ],
            ]; 
        });
        return $formattedBudgets;
    }
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
