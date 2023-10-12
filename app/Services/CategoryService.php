<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
  protected $categoryRepository;

  public function __construct(CategoryRepository $categoryRepository)
  {
    $this->categoryRepository = $categoryRepository;
  }
  public function getCategories()
  {
    return $this->categoryRepository->getCategories();
  }
  public function createCategory($data)
  {
    $category = new Category;
    $category->budget_id = $data['budget_id'];
    $category->category_name = $data['category_name'];
    $category->category_limit = $data['category_limit'];
    $this->categoryRepository->save($category);
  }
}
