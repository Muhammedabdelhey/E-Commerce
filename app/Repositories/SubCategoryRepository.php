<?php

namespace App\Repositories;

use App\Models\SubCategory;
use App\Repositories\Interfaces\SubCategoryRepositoryInterface;

class SubCategoryRepository implements SubCategoryRepositoryInterface
{
    public function __construct(private SubCategory $subCategory)
    {
    }
    // Implement interface methods here
    public function allSubCategories()
    {
        return $this->subCategory::with('category')->get();
    }
    public function createSubCategory(array $data)
    {
        return $this->subCategory::create($data);
    }
    public function updateSubCategory($subCategory, array $data)
    {
        return $subCategory->update($data);

    }
    public function deleteSubCategory($subCategory)
    {
        return $subCategory->delete();

    }
}
