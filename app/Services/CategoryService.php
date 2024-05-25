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
  public function createCategory($data)
  {
    $category = new Category;
    $category->budget_id = $data['budget_id'];
    $category->category_name = $data['category_name'];
    $category->category_limit = $data['category_limit'];
    $this->categoryRepository->save($category);
  }
  public function updateCategory($data, $id)
  {
    $category = Category::findOrFail($id);
    $category->category_limit = $data['category_limit'];
    $this->categoryRepository->update($category);
  }
  public function getDataForAnalytics($id, $month, $year)
  {
    return $this->categoryRepository->getDataForAnalytics($id, $month, $year);
  }
  public function createOrUpdateCategory(Request $request)
  {
    $data = $request->all();
    if (array_key_exists("id", $data) && $data['id']) {
      $this->updateCategory($request, $data["id"]);
    } else {
      $this->createCategory($request);
    }
  }
}
