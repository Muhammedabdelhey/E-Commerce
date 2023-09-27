<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {
    }
    public function index()
    {
        $cartitems = $this->cartService->getCartItems();
        return view('User.home.cart', compact('cartitems'));
    }

    public function add(Request $request, $product_id)
    {
        $this->cartService->addCartItem($request, $product_id);
        return redirect()->back()->with('message', 'added to cart');
    }

    public function update(Request $request, $cartItemId)
    {
        $this->cartService->updateCartItem($request, $cartItemId);
        return redirect()->back();
    }

    public function destory($cartItemId)
    {
        $this->cartService->deleteItem($cartItemId);
        return redirect()->back();
    }
}
