<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(private Cart $cart, private CartItem $cartItem)
    {
    }
    // Implement interface methods here
    public function create()
    {
        $cart = $this->cart->create([
            'user_id' => Auth::id()
        ]);
        return $cart;
    }

    public function getCartItems()
    {
        $cart = $this->cart->where('user_id', Auth::id())
            ->with('products.images', 'products.productColorSize.color', 'products.productColorSize.size')->first();
        return $cart->products;
    }

    public function addCartItem(array $data)
    {
        $this->cartItem->create($data);
        return $this->cartItem;
    }


    public function getCartItem($cartId, $productId)
    {
        $cartitem = $this->cartItem->where('cart_id', $cartId)->where('product_id', $productId)->first();
        return $cartitem;
    }

    public function updateCartItem(array $data, $cartItemId)
    {
        $cartitem = $this->cartItem->whereId($cartItemId)->update($data);
        return $cartitem;
    }

    public function deleteCartItems($cartItemIds)
    {
        $this->cartItem->destroy($cartItemIds);
    }
}
