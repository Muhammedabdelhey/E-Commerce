@extends('admin.dashboard_layout')
@section('title', 'edit Product')
@section('content')
    <div class="container my-5">
        <div class="text-center my-3">
            <h1>Edit Product</h1>
        </div>
        <div class="row justify-content-center">
            <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('Patch')
                <div class="col-md-12">
                    <div class="tab" id="productTab">
                        <!-- Product Data Fields -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name='title'
                                value="{{ $product->title }}" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Description" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="Price">Price</label>
                            <input type="number" class="form-control" id="Price" name="price" placeholder="Price"
                                value="{{ $product->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    @if ($category->id == $product->subcategory->category->id)
                                        <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory">SubCategory</label>
                            <select id="subcategory" name="subcategory_id" class="form-control">
                                <!-- Options will be dynamically populated using JavaScript -->
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" id="nextBtn" onclick="nextTab()"
                                class="btn btn-outline-primary">Next</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tab" id="productImages">
                        <div class="container">
                            <div class="row">
                                @foreach ($images as $image)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <img class="card-img-top" src="{{ asset($image->path) }}" alt="Product Image"
                                                style="width: 150px; height: 200px;">
                                            <div
                                                class="card-body d-flex flex-column justify-content-center align-items-center">
                                                <button class="btn btn-danger delete-image"
                                                    data-image-id="{{ $image->id }}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Add Image section -->
                                <!-- Check if you have 2 images in the current row -->
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 w-100">
                                        <div class="card-body text-center">
                                            <h4>Add Image</h4>
                                            <label for="fileInput" class="btn btn-outline-secondary">
                                                <i class="mdi mdi-file-plus mdi-48px"></i>
                                                <input type="file" class="form-control-file" id="fileInput"
                                                    name="images[]" multiple>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-4">
                            <button type="button" id="prevBtn" onclick="prevTab()"
                                class="btn btn-outline-secondary mx-3">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextTab()"
                                class="btn btn-outline-success mx-3">Next</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tab" id="productSizeColorTab">
                        <div id="colorSizeInputs">
                            @foreach ($product->productColorSize as $index => $row)
                                {{-- @dd($product->productColorSize->count()) --}}
                                <div class="row color-input-template">
                                    <div class="col-md-4">
                                        <label for="color">Color</label>
                                        <select name="colors[{{ $index }}]" class="form-control">
                                            {{-- <option value="" disabled selected>Select Color</option> --}}
                                            @foreach ($colors as $color)
                                                @if ($row->color_id == $color->id)
                                                    <option selected value="{{ $color->id }}">{{ $color->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="size">Size</label>
                                        <select name="sizes[{{ $index }}]" class="form-control">
                                            {{-- <option value="" disabled selected>Select Size</option> --}}
                                            @foreach ($sizes as $size)
                                                @if ($row->size_id == $size->id)
                                                    <option selected value="{{ $size->id }}">{{ $size->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantities[{{ $index }}]"
                                            value="{{ $row->quantity }}" class="form-control" min="0"
                                            required>
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <button type="button"
                                            class="btn btn-outline-danger my-2 remove-input-field">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <button type="button" id="addRow" class="btn btn-outline-primary">Add Row</button>
                        <div class="text-center mt-4">
                            <button type="button" id="prevBtn" onclick="prevTab()"
                                class="btn btn-outline-secondary mx-5">Previous</button>
                            <button type="submit" class="btn btn-outline-info ">Update Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            jQuery('.delete-image').click(function() {
                event.preventDefault(); // Prevent the default form submission behavior
                var image_id = $(this).data('image-id'); // Use data-image-id to get the image ID
                var product_id = {{ $product->id }};
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('product.image.delete', ['image_id' => 'id']) }}'.replace('id', image_id),
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        console.log('CSRF Token:', $('meta[name="csrf-token"]').attr(
                        'content'));
                        console.log('Image ID:', image_id);
                    }
                });
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
    <script>
        $(document).ready(function() {
            let indexCounter =
                {{ $product->productColorSize->count() }}; // Set the index counter based on existing rows

            function updateIndexes() {
                $('.color-input-template').each(function(index) {
                    $(this).find('[name^="colors"]').attr('name', `colors[${index}]`);
                    $(this).find('[name^="sizes"]').attr('name', `sizes[${index}]`);
                    $(this).find('[name^="quantities"]').attr('name', `quantities[${index}]`);
                });
            }
            // Add a new row
            $('#addRow').click(function() {
                const newRow = `
                    <div class="row color-input-template">
                                <div class="col-md-4">
                                    <label for="color">Color</label>
                                    <select name="colors[${indexCounter}]" class="form-control">
                                        @foreach ($colors as $color)

                                                <option value="{{ $color->id }}">{{ $color->name }}</option> 
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="size">Size</label>
                                    <select name="sizes[${indexCounter}]" class="form-control">
                                        {{-- <option value="" disabled selected>Select Size</option> --}}
                                        @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantities[${indexCounter}]" "
                                        class="form-control" min="0" required>
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <button type="button"
                                        class="btn btn-outline-danger my-2 remove-input-field">Remove</button>
                                </div>
                            </div>
                `;

                $('#colorSizeInputs').append(newRow);
                indexCounter++; // Increment the counter before updating indexes
                updateIndexes(indexCounter); // Update indexes after adding a row starting from indexCounter
            });

            // Remove a row
            $(document).on('click', '.remove-input-field', function() {
                const $rowToRemove = $(this).closest('.color-input-template');

                if (indexCounter > 1) {
                    $rowToRemove.remove();
                    updateIndexes(); // Update indexes after removing a row
                    indexCounter--; // Decrement the counter after updating indexes
                }
            });
        });
    </script>
    <script>
        var selectedCategoryId = $('#category').val();
        var subcategories = @json($categories->pluck('subcategories', 'id'));
        var selectedSubcategories = subcategories[selectedCategoryId];
        var subcategoryId = {{ $product->subcategory_id }}; // PHP value passed to JavaScript

        selectedSubcategories.forEach(function(subcategory) {
            var option = $('<option>', {
                value: subcategory.id,
                text: subcategory.name
            });

            if (subcategory.id == subcategoryId) {
                option.prop('selected', true);
            }
            $('#subcategory').append(option);
        });
        $(document).ready(function() {
            $('#category').on('change', function() {
                var selectedCategoryId = $(this).val();

                // Clear existing subcategory options
                $('#subcategory').empty();

                // Get the subcategories associated with the selected category
                //create jeson array [key->category_id, value ->subCategories]
                var subcategories = @json($categories->pluck('subcategories', 'id'));
                // get subcategories based on selecet category
                var selectedSubcategories = subcategories[selectedCategoryId];
                // Populate the subcategory dropdown with selected subcategories
                if (selectedSubcategories) {
                    selectedSubcategories.forEach(function(subcategory) {
                        $('#subcategory').append($('<option>', {
                            value: subcategory.id,
                            text: subcategory.name
                        }));
                    });
                }

            });
        });
    </script>
@endsection
