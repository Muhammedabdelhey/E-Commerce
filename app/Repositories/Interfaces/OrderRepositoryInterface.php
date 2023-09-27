<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    // Define interface methods here
    public function find($order_id);
    public function create(array $data);
    public function update($order_id, array $data);
    public function delete($order_id);

}
