<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\CartService;
use App\Services\OrderService;


class OrderController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {
    }
    public function create()
    {
        $cartProducts = $this->cartService->getCartItems();
        $colors = $cartProducts->map(function ($product) {
            return [
                'product_id' => $product->id,
                'colors' => $product->productColorSize->pluck('color')->unique(),
            ];
        })->keyBy('product_id')->toArray();


        $sizes = $cartProducts->map(function ($product) {
            return [
                'product_id' => $product->id,
                'sizes' => $product->productColorSize->pluck('size')->unique(),
            ];
        })->keyBy('product_id')->toArray();
        // dd($colors[1]);
        return view('User.home.order', compact('cartProducts', 'colors', 'sizes'));
    }
    public function store(OrderRequest $request)
    {
        $this->orderService->createOrder($request);
        return redirect()->route('products')->with('message', "Order confirmid successfully");
    }
}
