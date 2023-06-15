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
    public function getCategories()
    {
        return $this->categoryService->getCategories();
    }
} 
