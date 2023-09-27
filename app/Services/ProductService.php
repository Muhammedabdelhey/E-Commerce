<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Attacment;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ManageFileService $fileService
    ) {
    }

    public function getAllProducts()
    {
        $products = $this->productRepository->allProducts();
        $products->map(function ($product) {
            $totalQuantity = $product->productColorSize->sum('quantity');
            $product->quantity = $totalQuantity;
            return [$product];
        });
        return $products;
    }
    
    public function createProduct(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->createProduct([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'subcategory_id' => $request->subcategory_id
            ]);
            $this->attachProductImges($request['images'], $product);
            $this->addProductColorsSizesQuantities($request, $product);
            DB::commit();
            return $product;
            dd($product);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('an error occuer' . $e);
        }
    }

    public function updateProduct(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->updateProduct(
                $product,
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'price' => $request->price,
                    'subcategory_id' => $request->subcategory_id
                ]
            );
            $product->productColorSize()->delete();
            $this->addProductColorsSizesQuantities($request, $product);
            $this->attachProductImges($request['images'], $product);
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('an error occuer' . $e);
        }
    }

    public function deleteProduct(Product $product)
    {
        foreach ($product->images as $image) {
            $this->fileService->deleteFile($image->path);
        }
        $product->images()->delete();
        $product = $this->productRepository->deleteProduct($product);
    }

    public function attachProductImges($imageFiles, Product $product)
    {
        $imageData = [];
        if (isset($imageFiles) && !empty($imageFiles)) {
            foreach ($imageFiles as $imageFile) {
                $path = $this->fileService->uploadFile($imageFile, 'products');
                if ($path) {
                    $imageData[] = ['path' => $path];
                }
            }
        }
        $product->images()->createMany($imageData);
    }

    public function addProductColorsSizesQuantities(ProductRequest $request, Product $product)
    {
        $colors = $request->colors;
        $sizes = $request->sizes;
        $quantities = $request->quantities;
        $data = [];
        foreach ($colors as $index => $colorId) {
            $sizeId = $sizes[$index];
            $quantity = $quantities[$index];

            $data[] = [
                'color_id' => $colorId,
                'size_id' => $sizeId,
                'quantity' => $quantity,
            ];
        }
        $product->productColorSize()->createMany($data);
    }

    public function deleteImgae($id){
        $image=Attacment::find($id);
        if($image){
            $this->fileService->deleteFile($image->path);
            $image->delete();
        }
    }
}
