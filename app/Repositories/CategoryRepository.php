<?php

namespace App\Repositories;
use App\Http\Controllers\BudgetController;
use App\Models\Category;

class CategoryRepository
{
    protected $category;
   private BudgetController $budgetController;

    public function __construct(BudgetController $budgetController) 
    {
      $this->category = new Category();
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
  public function getCategories()
  {
    return Category::all();
  }
}
 