<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $category;
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function getCategories()
    {
        return Category::all();
    }
    public function createOrUpdateCategory(Request $data)
    {
        $this->categoryService->createOrUpdateCategory($data);
    }
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }
    public function getDataForAnalytics($id, $month, $year)
    {
        return $this->categoryService->getDataForAnalytics($id, $month, $year);
    }
}
