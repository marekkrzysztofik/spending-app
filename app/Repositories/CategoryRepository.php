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
    public function save($category)
    {
        $category->save();
    }
    public function update($student)
  {
    $student->update();
  }
  public function getCategories()
  {
      return Category::all();
  }
}
 