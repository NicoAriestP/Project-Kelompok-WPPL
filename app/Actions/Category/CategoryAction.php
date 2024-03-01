<?php

namespace App\Actions\Category;

use App\Http\Requests\Category\CategoryFormRequest;
use App\Models\Category;

class CategoryAction
{
    /**
     * Save a new category.
     *
     * @param CategoryFormRequest $request The form request containing the category data.
     * @return Category The saved category.
     */
    public function save(CategoryFormRequest $request): Category
    {
        $validated = $request->validated();

        $category = Category::create($validated);

        return $category;
    }

    /**
     * Update an existing category.
     *
     * @param Category $category The category to be updated.
     * @param CategoryFormRequest $request The form request containing the updated category data.
     * @return Category The updated category.
     */
    public function update(Category $category, CategoryFormRequest $request): Category
    {
        $validated = $request->validated();

        $category->update($validated);

        return $category;
    }

    /**
     * Delete a category.
     *
     * @param Category $category The category to be deleted.
     * @return void
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
