@extends('admin.dashboard_layout')
@section('title', 'Add Category')
@section('content')
    <div class="text-center my-3">
        <h1>Add Category</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-inline" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="form-group mx-sm-3 mb-2 my-3">
                <input type="text" name='name' id="name" placeholder="Category Name" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add</button>
        </form>
    </div>

@endsection
