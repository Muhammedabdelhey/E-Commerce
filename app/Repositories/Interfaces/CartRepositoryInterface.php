<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    // Define interface methods here
    public function create();
    public function getCartItems();
    public function addCartItem(array $data);
    public function updateCartItem(array $data,$cartItemId);
    public function deleteCartItems($cartItemId);
    public function getCartItem($cartId, $productId);

}
