<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function allCategories();
    public function createCategory(array $data);
    public function updateCategory($category,array $data);
    public function deleteCategory($category);
}
