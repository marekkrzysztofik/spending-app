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
    $category->name = $data['name'];
    $category->user_id = $data['user_id'];
    $this->categoryRepository->save($category);
  }
}
