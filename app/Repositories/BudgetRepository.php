<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
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
        $currentMonth = $currentMonth ?? $this->currentMonth;
        $currentYear = $currentYear ?? $this->currentYear;
        $budgets = Budget::with('categories')->where('user_id', '=', $id)->get();
        // $budgets = $this->budget->where('budgets.user_id', '=', $id)->get();
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
    public function getDataForBudgetsComponent($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        $formattedBudgets = $budgets->map(function ($budget) {
            $sum = Category::withSum('transactions', 'amount')->join('budgeted_amounts', 'categories.id', '=', 'budgeted_amounts.category_id')->where('categories.budget_id', '=', $budget->id)->get();
            return [
                'name' => $budget['name'],
                'categories' => $sum,
            ];
        });
        return $formattedBudgets;
    }
    public function getDataForNewTransaction($id)
    {
        $budgets = $this->currentBudgetsWithCategories($id);
        return $budgets;
    }
    protected function getCategoriesWithBudgetedAmounts($id, $currentMonth = null, $currentYear = null)
    {
        $currentMonth = $currentMonth ?? $this->currentMonth;
        $currentYear = $currentYear ?? $this->currentYear;
        $categoriesWithBudgetedAmounts = Category::join('budgeted_amounts', 'categories.id', '=', 'budgeted_amounts.category_id')->where('categories.budget_id', '=', $id)->whereMonth('budgeted_amounts.date', '=', $currentMonth)->whereYear('budgeted_amounts.date', '=', $currentYear)->get();
        return $categoriesWithBudgetedAmounts;
    }
    public function getBudgetsForCategoriesComponent($id)
    {

        $budgets = $this->budget->where('budgets.user_id', '=', $id)->get();
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget->id,
                'name' => $budget->name,
                'categories' => $this->getCategoriesWithBudgetedAmounts($budget->id),
                // 's' => $this->getCategoriesWithBudgetedAmounts($budget->id)->sum('transactions_sum_amount')
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
