<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    public function index(): JsonResponse
    {
        $categories = Category::paginate();
        return $this->showAll($categories);
    }
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $this->validate($request, $rules);

        $category = Category::create($request->all());
        return $this->showOne($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $category->fill($request->only(['name', 'description']));
        if($category->isClean()) {
            return $this->errorResponse("You need to specify any different value to update", 422);
        }
        $category->save();
        return $this->showOne($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
