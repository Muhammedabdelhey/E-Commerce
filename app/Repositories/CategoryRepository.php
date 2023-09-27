<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(private Category $category)
    {
        
    }
    // Implement interface methods here
    public function allCategories()
    {
        return $this->category::with('subcategories')->get();
    }
    public function createCategory(array $data)
    {
        return $this->category::create($data);
    }
    public function updateCategory($category, array $data)
    {
        return $category->update($data);

    }
    public function deleteCategory($category)
    {
        return $category->delete();

    }
}
