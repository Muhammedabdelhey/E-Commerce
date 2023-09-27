@extends('admin.dashboard_layout')
@section('title', 'Add SubCategory')
@section('content')
    <div class="text-center my-3">
        <h1>Add SubCategory</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-group" method="POST" action="{{ route('subcategory.store') }}">
            @csrf
            <div class="form-group ">
                <label for="name">Name</label>
                <br>
                <input  type="text" name='name' id="name" placeholder="Category Name" required>
            </div>
            <div class="form-group ">
                <label for="category">Category</label>
                <br>
                <select id="category" name='category_id'class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add</button>
        </form>
    </div>
    </div>
@endsection
