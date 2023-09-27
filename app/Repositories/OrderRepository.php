<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(private Order $order)
    {
    }
    // Implement interface methods here
    public function create(array $data)
    {
        $order=$this->order->create($data);
        return $order;
    }
    public function find($order_id)
    {
        $order = $this->order->with('products')->whereId($order_id)->get();
        return $order;
    }
    public function update($order_id, array $data)
    {
        $order = $this->order->whereId($order_id)->update($data);
        return $order;
    }
    public function delete($order_id)
    {
        $this->order->delete($order_id);
    }
}
