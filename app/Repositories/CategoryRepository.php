<?php

namespace App\Repositories;
use App\Http\Controllers\BudgetController;
use App\Models\Category;
use App\Models\Budget;

class CategoryRepository
{ 
    protected $category;
    protected $budget;
   private BudgetController $budgetController;

    public function __construct(BudgetController $budgetController) 
    {
      $this->category = new Category();
      $this->budget = new Budget();
      $this->budgetController = $budgetController;
    }
    public function getCategoriesByBudgetId($id)
    { 
      return $this->category->where('budget_id', '=', $id)->withSum('transactions', 'amount')->get();
    }
    public function getCategoryById($id)
    {
      return $this->category->find($id);
    }
    public function save($category)
    {
      $category->save();
      event(new \App\Events\CategoryCreated($category->id));
    }
    public function update($category) 
    {
      $category->update();
    }
    public function delete($id)
  {
    $category = $this->category->findOrFail($id);
    $category->delete();
  }
  public function getDataForAnalytics($id,$month,$year)
    {
        $budgets = Budget::with('categories')->where('user_id', '=', $id)->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->withSum('categories', 'category_limit')->withSum('transactions', 'amount')->get();
        $formattedBudgets = $budgets->map(function ($budget) {
            return [
                'id' => $budget['id'],
                'name' => $budget['name'],
                'user_id' => $budget['user_id'],
                'limit' => $budget['limit'],
                'categories_sum' =>$budget['transactions_sum_amount'],
      
                'labels' => $budget->categories->pluck('category_name')->toArray(),
                'datasets' => [
                  [
                      'backgroundColor' => ['#41B883'],
                      'data' => $budget->categories->pluck('limit')->toArray()
                  ],
                
              ]
            ];
        });
        return $budgets;
    }

  public function getCategories()
  {
    return Category::all();
  }
}
 