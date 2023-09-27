<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Models\ProductColorSize;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CartRepository $cartRepository
    ) {
    }
    public function createOrder(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepository->create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment' => $request->payment,
                'status' => 0,
            ]);
            $orderProducts = $this->getOrderProducts($request);
            $this->updateProductsQuantity($request);
            $this->deleteProductFromCart($request);
            $order->products()->attach($orderProducts);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            Db::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    private function getOrderProducts(OrderRequest $request): array
    {
        $data = [];
        foreach (array_keys($request->product_ids) as $product_id) {

            $colors = $request->colors;
            $sizes = $request->sizes;
            $quantity = $request->quantity;
            $data[] = [
                'product_id' => $product_id,
                'color_id' => $colors[$product_id],
                'size_id' => $sizes[$product_id],
                'quantity' => $quantity[$product_id],
            ];
        }
        return $data;
    }
    private function updateProductsQuantity(OrderRequest $request): void
    {
        $products = $this->getOrderProducts($request);
        foreach ($products as $product) {
            $productColorSize = ProductColorSize::where([
                'product_id' => $product['product_id'],
                'color_id' => $product['color_id'],
                'size_id' => $product['size_id']
            ])->first();
            $quantity = $product['quantity'];
            $productColorSize->quantity = $productColorSize->quantity - $quantity;
            $productColorSize->save();
        }
    }

    private function deleteProductFromCart(OrderRequest $request): void
    {
        $itemIds = array_values($request->product_ids);
        $this->cartRepository->deleteCartItems($itemIds);
    }
}
