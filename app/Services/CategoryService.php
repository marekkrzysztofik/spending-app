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
  public function getCategoryById($id)
  {
    return $this->categoryRepository->getCategoryById($id);
  }
  public function getCategoriesByBudgetId($id)
  {
    return $this->categoryRepository->getCategoriesByBudgetId($id);
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
    $category = $this->categoryRepository->getCategoryById($id);
    $category->category_limit = $data['category_limit'];
    $this->categoryRepository->update($category);
  }
  public function getCategories()
  {
    return $this->categoryRepository->getCategories();
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
    public function deleteCategory($id)
  {
    $this->categoryRepository->delete($id); 
  }
}
