<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Repositories\CategoryRepository;
use App\Services\ManageFileService;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ManageFileService $fileservice,
        private CategoryRepository $categoryRepository,
        private ProductService $productService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        // dd($products);
        return view('admin.products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryRepository->allCategories();
        $colors = Color::all();
        $sizes = Size::all();
        return view(
            'admin.products.addproduct',
            compact('categories', 'colors', 'sizes')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->createProduct($request);
        if ($product) {
            return redirect()->route('products.index')->with('message', 'product added successfully');
        }
        return redirect()->back()->with('error', 'An Error Ouccerd  ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryRepository->allCategories();
        $colors = Color::all();
        $sizes = Size::all();
        $images = $product->images;
        $product->productColorSize;
        $product->subcategory->category;
        // dd($product);
        return view('admin.products.editproduct', compact('product', 'categories', 'colors', 'sizes', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {

        $product = $this->productService->updateProduct($request, $product);
        if (!$product) {
            return redirect()->back()->with('error', 'An Error Ouccerd  ');
        }
        return redirect()->route('products.index')->with('message', 'product Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('products.index')->with('message', 'Product Deleted ');
    }

    public function deleteProductImage($image_id)
    {
        $this->productService->deleteImgae($image_id);
        return redirect()->back();
    }
}
