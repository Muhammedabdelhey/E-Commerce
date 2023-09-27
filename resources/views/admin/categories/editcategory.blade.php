@extends('admin.dashboard_layout')
@section('title', 'Edit Category')
@section('content')
    <div class="text-center my-3">
        <h1>Edit Category</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-inline" method="POST" action="{{ route('categories.update',$category->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group mx-sm-3 mb-2 my-3">
                <input type="text" name='name' value="{{ $category->name }}"  id="name" placeholder="Category Name" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Update</button>
        </form>
    </div>
    </div>
@endsection
