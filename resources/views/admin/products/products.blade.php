@extends('admin.dashboard_layout')
@section('title', 'All Prodcuts')
@section('content')
    <div class="text-center my-3">
        <h1> Products</h1>
    </div>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Category</th>
                <th scope="col">SubCategory</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->subcategory->category->name }}</td>
                    <td>{{ $product->subcategory->name }}</td>

                    <td>
                        <img src="{{ asset($product->images[0]->path) }}" alt="Product Image"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                    </td>
                    <td>
                        <a href="#" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list">
                            <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                class="dropdown-item preview-item">
                                <i class=" mx-2 preview-icon rounded-circle mdi mdi-pencil  text-success"></i>
                                <div class="preview-item-content">
                                    <p>Edit</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="post" action="{{ route('products.destroy', ['product' => $product->id]) }}"
                                onsubmit="return confirmDelete('Product')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn dropdown-item preview-item">
                                    <i class=" mx-2 preview-icon rounded-circle mdi mdi-pencil  text-danger"></i>
                                    <div class="preview-item-content">
                                        <p>delete</p>
                                    </div>
                                </button>

                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <p>No Products yet</p>
            @endforelse


        </tbody>
    </table>
    {{-- {{ $products->links() }} --}}
@endsection
