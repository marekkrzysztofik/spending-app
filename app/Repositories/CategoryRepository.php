<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected $category;
    public function __construct()
    {
      $this->category = new Category();
    }
    public function getCategoriesByBudgetId($id)
    {
      return $this->category->where('budget_id', '=', $id)->get();
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
  public function getCategories()
  {
    return Category::all();
  }
}
 