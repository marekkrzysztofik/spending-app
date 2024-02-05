<?php

namespace App\Repositories;

use App\Models\Budget;
use App\Models\Transaction;

class BudgetRepository
{
    protected $budget;
    protected $transaction;
    public function __construct()
    {
        $this->budget = new Budget();
        $this->transaction = new Transaction();
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
    public function getBudgetsByUserId($id, $month, $year)
    {
        return $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get();
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
