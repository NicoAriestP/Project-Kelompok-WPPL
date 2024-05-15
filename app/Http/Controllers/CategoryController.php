<?php

namespace App\Http\Controllers;

use App\Actions\Category\CategoryAction;
use App\Http\Requests\Category\CategoryFormRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new CategoryController instance.
     *
     * @param CategoryAction $categoryAction
     */
    public function __construct(
        protected CategoryAction $categoryAction
    ) {
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $categories = Category::query()->get();

            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new category.
     *
     * @param CategoryFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CategoryFormRequest $request): CategoryResource
    {
        try {
            $category = $this->categoryAction->save($request);

            return CategoryResource::make($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get the details of a specific category.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Category $category): CategoryResource
    {
        try {
            return CategoryResource::make($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update a specific category.
     *
     * @param Category $category
     * @param CategoryFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Category $category, CategoryFormRequest $request)
    {
        try {
            $category = $this->categoryAction->update($category, $request);

            return CategoryResource::make($category);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete a specific category.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->categoryAction->delete($category);

            return response()->json([
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get the total number of categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function total_category(): JsonResponse
    // {
    //     try {
    //         // count category per team (using leader_id)
    //         $user = auth()->user();
    //         $total = Category::whereHas('user', function ($query) use ($user) {
    //             $query->where('leader_id', $user->id);
    //         })->count();

    //         return response()->json([
    //             'total' => $total,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
