@extends('User.master_layout')
@section('title', 'Shopping Cart')
@section('content')
    <div class="container mt-2">
        <h2>Your Cart</h2>
        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    @php
                        $total = 0; // Initialize the total
                    @endphp
                    @forelse ($cartitems as $product)
                        <li class="list-group-item d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($product->images[0]->path) }}" alt="{{ $product->title }}"
                                    class="product-image">
                                <div class="ml-3">
                                    <h5>{{ $product->title }}</h5>
                                    <p>{{ $product->price }}$</p>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('cart.update', ['cartItemId' => $product->pivot->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group mb-2">
                                        <input type="number" name="quantity" class="form-control"
                                            value="{{ $product->pivot->quantity }}">
                                        <div class="input-group-append">
                                            <button class="mx-3 btn btn-info" type="submit">Update</button>
                                        </div>
                                    </div>
                                </form>
                                <p>Total: {{ $product->pivot->quantity * $product->price }}$</p>
                                <form action="{{ route('cart.delete', ['cartItemId' => $product->pivot->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                        @php
                            $total += $product->pivot->quantity * $product->price; // Update the total
                        @endphp
                    @empty
                        <p>Your Cart is Empty. Go To Shopping </p>
                    @endforelse
                </ul>
                <div class="text-right mt-3">
                    <h5>Total: {{ $total }}$</h5>
                    <a href="{{ route('order.view') }}" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
@endsection
