<?php

namespace App\Services;

use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }
    // Implement interface methods here
    public function getUserCart()
    {
        if (!Auth::user()->cart) {
            $this->cartRepository->create();
        }
        $cart = Auth::user()->cart;
        return $cart;
    }
    public function getCartItems()
    {
        $cartitems = $this->cartRepository->getCartItems();
        return $cartitems;
    }
    public function addCartItem(Request $request, $productId)
    {
        $cart = $this->getUserCart();
        // error_log($cart);
        $cartitem = $this->cartRepository->getCartItem($cart->id, $productId);
        if ($cartitem) {
            // error_log("product on cart update quantity");
            $this->cartRepository->updateCartItem([
                'quantity' => $cartitem->quantity + $request->quantity
            ], $cartitem->id);
        } else {
            // error_log("product not on cart ");
            $cartitem = $this->cartRepository->addCartItem([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $request->quantity
            ]);
        }
        // error_log($cartitem);
        return $cartitem;
    }
    public function updateCartItem(Request $request, $cartItemId)
    {
        if (!$request->quantity > 0) {
            $this->cartRepository->deleteCartItems([$cartItemId]);
        }
        $cartItem = $this->cartRepository->updateCartItem([
            'quantity' => $request->quantity
        ], $cartItemId);

        return $cartItem;
    }
    public function deleteItem($cartItemId)
    {
        $this->cartRepository->deleteCartItems([$cartItemId]);
    }
}
