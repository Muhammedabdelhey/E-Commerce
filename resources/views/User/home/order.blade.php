@extends('User.master_layout')
@section('title', 'Confirm order')
@section('content')
    <div class="container mt-2">
        <h2>Checkout Cart</h2>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="tab">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($cartProducts as $product)
                                <li class="list-group-item">
                                    <div class="row ">
                                        <div class="col-sm-1 d-flex">
                                            <input class="form-check selected-products" type="checkbox"
                                                name="product_ids[{{ $product->id }}]" value="{{ $product->pivot->id }}"
                                                data-price="{{ $product->price }}"
                                                data-quantity="{{ $product->pivot->quantity }}" checked
                                                id="product-checkbox-{{ $product->pivot->id }}">
                                        </div>
                                        <!-- Left Section: Product Image, Name, and Price -->
                                        <div class="col-sm-3">
                                            <div>
                                                <h5>{{ $product->title }}</h5>
                                                <img src="{{ asset($product->images[0]->path) }}"
                                                    alt="{{ $product->title }}" class="product-image">
                                                <h6 class="my-2">Price :{{ $product->price }}$</h6>

                                            </div>
                                        </div>
                                        <!-- Middle Section: Colors and Sizes -->
                                        <div class="col-sm-6">
                                            <div id="product-colors-{{ $product->id }}">
                                                <h5>Colors</h5>
                                                @foreach ($colors[$product->id]['colors'] as $color)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input mt-3 color-option" type="radio"
                                                            id="color{{ $color->id }}"
                                                            name="colors[{{ $product->id }}]" value="{{ $color->id }}"
                                                            data-product-id="{{ $product->id }}">
                                                        <label class="form-check-label"
                                                            for="color{{ $color->id }}">{{ $color->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div id="product-sizes-{{ $product->id }}">
                                                <h5>Sizes</h5>
                                                <div class="row">
                                                    @foreach ($sizes[$product->id]['sizes'] as $size)
                                                        <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                                                            <div class="card size-card mb-3">
                                                                <input class="form-check-input size-options" type="radio"
                                                                    id="size{{ $size->id }}"
                                                                    name="sizes[{{ $product->id }}]"
                                                                    value="{{ $size->id }}" disabled>
                                                                <label for="size{{ $size->id }}"
                                                                    class="form-check-label ml-sm-4 ml-md-5 ml-xl-4">
                                                                    {{ $size->abbreviation }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Right Section:  -->
                                        <div class="col-sm-3 col-lg-2 p-3">
                                            <div class="input-group mb-3 d-flex">
                                                <input type="number" name="quantity[{{ $product->id }}]"
                                                    class="form-control" value="{{ $product->pivot->quantity }}"
                                                    id="update-quantity" data-item-id="{{ $product->pivot->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <p>Your Cart is Empty. Go To Shopping</p>
                            @endforelse
                        </ul>
                        <div class="text-right mt-3">
                            <h5><span id="total-price">Total: 0.00$</span></h5>
                            <button type="button" id="nextBtn" onclick="nextTab()"
                                class="btn btn-outline-primary">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab">
                <div class="col-sm-12 col-md-10 col-lg-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" placeholder="Enter Your Full Name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="Address" name="address"
                            value="{{ old('address') }}" placeholder="Enter Your Address" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Number</label>
                        <input type="text" class="form-control" id="number" name="phone"
                            value="{{ old('phone') }}" placeholder="Enter Your Number" required>
                    </div>
                </div>
                <div class="col-sm-12 ">
                    <div class="form-check-inline">
                        <input class="form-check-input mt-3" type="radio" id="cash-payment" name="payment" value="0"
                            {{ old('payment') === '0' ? 'checked' : ' ' }} required>
                        <label class="form-check-label" for="cash-payment">Cash On Delivery</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input mt-3" type="radio" id="card-payment" name="payment" value="1"
                            {{ old('payment') === '1' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="card-payment">Credit Card</label>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="prevBtn" onclick="prevTab()"
                            class="btn btn-outline-secondary mx-2">Previous</button>
                        <button type="submit" class="btn btn-primary ">Make Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {

            // Add an event listener to all color inputs with the class "color-option"
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach((colorOption) => {
                colorOption.addEventListener('change', function() {
                    // Get the selected color ID from the data attribute
                    const selectedColorId = colorOption.value;
                    const productId = this.getAttribute('data-product-id');
                    // Loop through all size inputs for the specific product and update their availability based on the selected color ID
                    const sizeOptions = document.querySelectorAll(
                        `#product-sizes-${productId} .size-options`);
                    sizeOptions.forEach((sizeOption) => {
                        const sizeId = sizeOption.value;
                        const isSizeAvailable = checkSizeAvailability(productId,
                            selectedColorId,
                            sizeId);
                        sizeOption.disabled = !isSizeAvailable;
                        // Get the parent div for each size input
                        const parentDiv = sizeOption.closest('.size-card');
                        const existingQuantityDisplay = parentDiv.querySelector(
                            '.quantity-display');
                        if (existingQuantityDisplay) {
                            existingQuantityDisplay.remove();
                        }
                        const quantityDisplay = document.createElement('p');
                        var quantity =
                            ` Q : ${getQuantity(productId, selectedColorId, sizeId)}`;
                        quantityDisplay.textContent = quantity;
                        quantityDisplay.classList.add('quantity-display', 'ml-sm-1',
                            'ml-md-2',
                            'ml-xl-1');
                        parentDiv.appendChild(quantityDisplay);
                    });
                });
            });

            function checkSizeAvailability(productId, selectedColorId, sizeId) {
                var productsColorSizes = @json($cartProducts->pluck('productColorSize', 'id'));
                var product = productsColorSizes[productId];

                var productscart = @json($cartProducts->pluck('pivot', 'id'));
                var productpivot = productscart[productId];

                var isSizeAvailable = false; // Assume the size is not available by default
                product.forEach((colorsizequntity) => {
                    if (
                        colorsizequntity.color_id == selectedColorId &&
                        colorsizequntity.size_id == sizeId &&
                        colorsizequntity.quantity >= productpivot.quantity
                    ) {
                        isSizeAvailable = true;
                    }
                });
                return isSizeAvailable;
            }

            function getQuantity(productId, selectedColorId, sizeId) {

                var productsColorSizes = @json($cartProducts->pluck('productColorSize', 'id'));
                var product = productsColorSizes[productId];
                var quantity = 0; // Initialize the quantity to 0
                product.forEach((colorsizequntity) => {
                    if (
                        colorsizequntity.color_id == selectedColorId &&
                        colorsizequntity.size_id == sizeId
                    ) {
                        quantity = colorsizequntity.quantity;
                    }
                });
                return quantity;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize the total
            var totalPrice = 0;

            // Function to update the total
            function updateTotal() {
                totalPrice = 0;
                $('.selected-products:checked').each(function() {
                    var quantity = parseInt($(this).data('quantity'));
                    totalPrice += parseFloat($(this).data('price')) * quantity;
                });
                $('#total-price').text('Total: ' + totalPrice.toFixed(2) + '$');
            }

            // Initial update of the total
            updateTotal();

            // Event handler for changes in quantity
            $(document).on('change', '#update-quantity', function() {
                var item_id = $(this).data('item-id');
                var newQuantity = $(this).val();
                // Prepare the data to send in the Ajax request
                var data = {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    _method: 'PATCH', // Specify the HTTP method
                    quantity: newQuantity // New quantity value
                };

                var routeUrl = '{{ route('cart.update', ['cartItemId' => ':cartItemId']) }}';
                routeUrl = routeUrl.replace(':cartItemId', item_id);

                // Send the Ajax request
                $.ajax({
                    url: routeUrl,
                    method: 'POST', // Use POST for Laravel method spoofing
                    data: data,
                    success: function(response) {
                        var checkbox = $(`#product-checkbox-${item_id}`);
                        checkbox.data('quantity', newQuantity);
                        updateTotal(); // Update the 
                        console.log('Quantity updated successfully');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error updating quantity: ' + textStatus);
                    }
                });
            });
            $('.selected-products').change(function() {
                updateTotal(); // Update the total when checkbox selection changes
            });
        });
    </script>
    <script>
        let currentTab = 0;
        showTab(currentTab);

        function showTab(tabIndex) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach((tab, index) => {
                if (index === tabIndex) {
                    tab.style.display = 'block';
                } else {
                    tab.style.display = 'none';
                }
            });
            // Show/hide navigation buttons
            document.getElementById('prevBtn').style.display = tabIndex === 0 ? 'none' : 'inline';
            document.getElementById('nextBtn').style.display = tabIndex === tabs.length - 1 ? 'none' : 'inline';
        }

        function nextTab() {
            const tabs = document.querySelectorAll('.tab');
            const currentFields = tabs[currentTab].querySelectorAll('[required]');
            const areAllFieldsFilled = Array.from(currentFields).every(field => field.value.trim() !== '');

            if (areAllFieldsFilled) {
                if (currentTab < tabs.length - 1) {
                    currentTab++;
                    showTab(currentTab);
                }
            } else {
                // Required fields are not filled, so stay on the same tab
            }
        }

        function prevTab() {
            if (currentTab > 0) {
                currentTab--;
                showTab(currentTab);
            }
        }
    </script>


@endsection
