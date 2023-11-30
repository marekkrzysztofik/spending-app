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
                'budgets' => $budget->budgets,
                'categories' => $budget->categories->toArray(),
            ];
        });
        return $formattedBudgets;
    }
    public function getBudgetsByUserId($id, $month)
    {
        return $this->budget->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get();
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
