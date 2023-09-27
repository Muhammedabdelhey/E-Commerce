@extends('admin.dashboard_layout')
@section('title', 'Add Product')
@section('content')
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1>Add Product</h1>
        </div>
        <div class="row justify-content-center">
            <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="tab" id="productTab">
                        <!-- Product Data Fields -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name='title'
                                value="{{ old('title') }}" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Description" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="Price">Price</label>
                            <input type="number" class="form-control" id="Price" name="price" placeholder="Price"
                                value="{{ old('price') }}" required>
                        </div>
                        <!-- Product Images Fields -->
                        <div class="form-group">
                            <label for="images">Product Images</label>
                            <input type="file" class="form-control-file" id="images" name="images[]" multiple required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                            <button type="submit" id="nextBtn" onclick="nextTab()"
                                class="btn btn-outline-primary">Next</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tab" id="productSizeColorTab">
                        <div id="colorSizeInputs">
                            <div class="row color-input-template">
                                <div class="col-md-4">
                                    <label for="color">Color</label>
                                    <select name="colors[0]" class="form-control">
                                        {{-- <option value="" disabled selected>Select Color</option> --}}
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="size">Size</label>
                                    <select name="sizes[0]" class="form-control">
                                        {{-- <option value="" disabled selected>Select Size</option> --}}
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantities[0]" class="form-control" min="0" required>
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <button type="button"
                                        class="btn btn-outline-danger my-2 remove-input-field">Remove</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="button" id="addRow" class="btn btn-outline-primary">Add Row</button>
                        <div class="text-center mt-4">
                            <button type="button" id="prevBtn" onclick="prevTab()"
                                class="btn btn-outline-secondary mx-5">Previous</button>
                            <button type="submit" class="btn btn-outline-success ">Add Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let indexCounter = 1;

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
                updateIndexes();
                indexCounter++;
            });

            // Remove a row
            $(document).on('click', '.remove-input-field', function() {
                if (indexCounter > 1) {
                    $(this).closest('.color-input-template').remove();
                    updateIndexes(); // Update indexes after removing a row
                    indexCounter--;
                }
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
        jQuery(document).ready(function($) {
            // Populate subcategories when the page loads
            populateSubcategories($('#category').val());

            $('#category').on('change', function() {
                var selectedCategoryId = $(this).val();

                // Clear existing subcategory options
                $('#subcategory').empty();

                // Populate the subcategory dropdown with selected subcategories
                populateSubcategories(selectedCategoryId);
            });

            function populateSubcategories(categoryId) {
                var subcategories = @json($categories->pluck('subcategories', 'id'));
                var selectedSubcategories = subcategories[categoryId];

                if (selectedSubcategories) {
                    selectedSubcategories.forEach(function(subcategory) {
                        $('#subcategory').append($('<option>', {
                            value: subcategory.id,
                            text: subcategory.name
                        }));
                    });
                }
            }
        });
    </script>
@endsection
