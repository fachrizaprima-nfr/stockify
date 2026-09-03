<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();
        return view('pages.categories.index', compact('categories'));
    }
}