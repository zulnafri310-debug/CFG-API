<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() :JsonResponse{
        $categories = Category::withCount('words')->get();
        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request){
        $category = Category::create($request->validated());
        return response()->json([
            'message' => 'Category created successfully!',
            'data'    => $category,
        ], 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        $category->update($request->validated());
        return response()->json([
        'message' => 'Category updated successfully!',
        'data'    => $category,
        ]);
    }

    public function destroy(Category $category) :JsonResponse{
         $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully!',
        ]);
    }
    
}

