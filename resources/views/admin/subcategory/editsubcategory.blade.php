@extends('admin.dashboard_layout')
@section('title', 'Edit subcategory')
@section('content')
    <div class="text-center my-3">
        <h1>Edit subcategory</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-group" method="POST" action="{{ route('subcategory.update', $subcategory->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group ">
                <label for="name">Name</label>
                <input type="text" name='name' id='name' value="{{ $subcategory->name }}" id="name"
                    placeholder="subcategory Name" required class="form-control">
            </div>
            <div class="form-group ">
                <label for="category">Category</label>
                <select id="category" name='category_id'class="form-control">
                    @foreach ($categories as $category)
                    @if ($subcategory->category->id== $category->id)
                    <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                    @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Update</button>
        </form>
    </div>
    </div>
@endsection
