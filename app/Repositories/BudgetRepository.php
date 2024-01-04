<?php

namespace App\Repositories;

use App\Models\Budget;

class BudgetRepository
{
    protected $budget;
    public function __construct()
    {
        $this->budget = new Budget();
    }
    public function getBudgetsWithCategories()
    {
        $budgets = Budget::with('categories')->get();
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'name' => $budget['name'],
                'categories' => $budget->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'budget_id' => $category->budget_id,
                        'category_name' => $category->category_name,
                    ];
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
