<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    // Define interface methods here
    public function allProducts();
    public function createProduct(array $data);
    public function updateProduct($Product, array $data);
    public function deleteProduct($Product);
    public function getProduct($id);
}
