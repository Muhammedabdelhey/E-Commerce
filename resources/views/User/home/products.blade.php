@extends('User.master_layout')
@section('title', 'Products')
@section('content')
    <div class="alert alert-danger" id="error-alert" style="display: none;">
        Invalid quantity input. Please enter a valid number greater than 0.
    </div>
    <div class="alert alert-success" id="successAlert" style="display: none;">
        Added to Cart Successfully.
    </div>
    <section class="product_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Our <span>products</span>
                </h2>
            </div>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="box">
                            <div class="option_container">
                                <div class="options">
                                    <a href="#" class="option1" data-product-id="{{ $product->id }}">
                                        Add To Cart
                                    </a>
                                    {{-- <a href="" class="option2">
                                        Buy Now
                                    </a> --}}
                                    <a href="{{ route('product', ['id' => $product->id]) }}" class="option3">
                                        View Product
                                    </a>
                                </div>
                            </div>
                            <div class="img-box">
                                <img src="{{ asset($product->images[0]->path) }}" alt="Product Image">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    {{ $product->title }}
                                </h5>
                                <h6>
                                    {{ $product->price }}$
                                </h6>
                            </div>
                            <h6>{{ $product->subcategory->category->name . ' , ' . $product->subcategory->name }}</h6>
                        </div>
                    </div>
                @empty
                    <p>Sorry no Products yet</p>
                @endforelse
            </div>
            <div class="modal fade" id="quantity-modal" tabindex="-1" role="dialog" aria-labelledby="quantity-modal-label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="quantity-modal-label">Enter Quantity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id='add-to-cart'>
                            @csrf
                            <div class="modal-body">
                                <label for="quantity">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" value="1"class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="confirm-quantity" type="button" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var confirmButton = document.getElementById("confirm-quantity");
            var quantityInput = document.getElementById("quantity");
            var errorAlert = document.getElementById("error-alert");
            var successAlert = document.getElementById("successAlert");
            var addToCartButtons = document.querySelectorAll(".option1");
            var cartContainer = document.querySelector(".cart-container");

            addToCartButtons.forEach(function(button) {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    var productId = button.getAttribute("data-product-id");
                    $("#quantity-modal").modal("show");
                    confirmButton.setAttribute("data-product-id",
                        productId); // Assign the correct product ID to the confirm button
                });
            });

            confirmButton.addEventListener("click", function() {
                var productId = confirmButton.getAttribute("data-product-id"); // Get the stored product ID
                var quantity = parseInt(quantityInput.value);

                if (!isNaN(quantity) && quantity > 0) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('cart.add', ['product_id' => ':product_id']) }}".replace(':product_id', productId), // Use the named route and replace the placeholder
                        data: JSON.stringify({
                            quantity: quantity
                        }),
                        contentType: "application/json", // Set the content type to JSON
                        cache: false,
                        success: function(data) {
                            successAlert.style.display = "block"; // Show the success alert
                            $("#quantity-modal").modal("hide");
                        },
                        error: function(reject) {
                            // Handle error if needed
                        },
                    });
                } else {
                    errorAlert.style.display = "block"; // Show the error alert
                }
            });

            quantityInput.addEventListener("input", function() {
                errorAlert.style.display = "none"; // Hide the error alert when the user starts typing
            });
        });
    </script>

@endsection
