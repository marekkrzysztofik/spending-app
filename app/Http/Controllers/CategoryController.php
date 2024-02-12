<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;


class CategoryController extends Controller
{
    protected $category;
   private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function createCategory(Request $data)
    {
        $this->categoryService->createCategory($data);
    }
    public function getCategoryById($id)
    {
        return $this->categoryService->getCategoryById($id);
    }
    public function getCategoriesByBudgetId($id)
    {
        return $this->categoryService->getCategoriesByBudgetId($id);
    }
    public function getCategories()
    {
        return $this->categoryService->getCategories();
    }
    public function createOrUpdateCategory(Request $data)
    {
        $this->categoryService->createOrUpdateCategory($data);
    }
    public function deleteCategory($id)
    {
      $this->categoryService->deleteCategory($id); 
    }
    public function getDataForAnalytics($id,$month,$year)
    {
        return $this->categoryService->getDataForAnalytics($id,$month,$year);
} 
}