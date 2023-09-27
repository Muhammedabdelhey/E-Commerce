@extends('User.master_layout')
@section('title', $product->title)
@section('content')
    <div class="alert alert-danger" id="error-alert" style="display: none;">
        Invalid quantity input. Please enter a valid number greater than 0.
    </div>
    <div class="alert alert-success" id="successAlert" style="display: none;">
        Added to Cart Successfully.
    </div>
    <header>
        <h1>{{ $product->title }}</h1>
    </header>
    <section class="single-product">
        <div class="single-product-content">
            <div class="single-product-image">
                <img src="{{ asset($product->images[0]->path) }}" alt="Product Image">
            </div>

        </div>
        <div class="single-product-description">
            <p>{{ $product->description }}</p>
            <p><strong>Price:</strong> {{ $product->price }}$</p>
            <a class="btn btn-danger mx-3" id="add-to-cart">Add to Cart</a>
            {{-- <a class="btn btn-info">Buy Now</a> --}}
        </div>
        <div class="modal fade" id="quantity-modal" tabindex="-1" role="dialog" aria-labelledby="quantity-modal-label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quantity-modal-label">Enter Quantity</h5>
                        <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id='add-to-cart'>
                        @csrf
                        <div class="modal-body">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" class="form-control">
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
            var addToCartButton = document.getElementById("add-to-cart");
            var confirmButton = document.getElementById("confirm-quantity");
            var quantityInput = document.getElementById("quantity");
            var errorAlert = document.getElementById("error-alert");

            addToCartButton.addEventListener("click", function(event) {
                event.preventDefault();
                $("#quantity-modal").modal("show");
            });

            confirmButton.addEventListener("click", function() {
                var quantity = parseInt(quantityInput.value);

                if (!isNaN(quantity) && quantity > 0) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var product = @json($product);
                    var requestData = {
                        quantity: quantity
                    };

                    $.ajax({
                        type: "POST",
                        url: "{{ route('cart.add', ['product_id' => ':product_id']) }}".replace(':product_id', product.id), // Use the named route and replace the placeholder
                        data: JSON.stringify(requestData),
                        contentType: "application/json", // Set the content type to JSON
                        cache: false,
                        success: function(data) {
                            // Handle success if needed
                            successAlert.style.display = "block"; // Show the error alert
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
