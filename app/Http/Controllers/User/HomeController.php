<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private ProductRepository $productRepository)
    {
    }
    public function userHome()
    {
        return view('User.home.index');
    }
    public function indexProducts()
    {
        $products = $this->productRepository->allProducts();
        return view('User.home.products', compact('products'));
    }

    public function viewProduct( $id){
        $product=$this->productRepository->getProduct($id);
        return view('User.home.product',compact('product'));
    }
}
