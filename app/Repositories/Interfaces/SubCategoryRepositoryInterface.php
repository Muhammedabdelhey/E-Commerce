<?php

namespace App\Repositories\Interfaces;

interface SubCategoryRepositoryInterface
{
    // Define interface methods here
    public function allSubCategories();
    public function createSubCategory(array $data);
    public function updateSubCategory($subCategory,array $data);
    public function deleteSubCategory($subCategory);
}
