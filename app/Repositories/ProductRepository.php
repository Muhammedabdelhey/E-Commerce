<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private Product $product)
    {
    }
    // Implement interface methods here
    public function allProducts()
    {
        return $this->product::with('subcategory.category','images')->get();
    }
    public function getProduct($id)
    {
        return $this->product::whereId($id)->first();
    }
    public function createProduct(array $data)
    {
        return $this->product::create($data);
    }
    public function updateProduct($Product, array $data)
    {
         $Product->update($data);
         return $Product;
    }
    public function deleteProduct($Product)
    {
        return $Product->delete();
    }

}
