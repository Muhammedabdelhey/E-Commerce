@extends('admin.dashboard_layout')
@section('title', 'SubCatagories')
@section('content')
    <div class="text-center my-3">
        <h1> SubCatagories</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($subcategories))
                        @forelse ($subcategories as $subcategory)
                            <tr>
                                <td>{{ $subcategory->name }}</td>
                                <td>{{ $subcategory->category->name }}</td>
                                <td><a class="btn btn-primary"
                                        href="{{ route('subcategory.edit', ['subcategory' => $subcategory->id]) }}">Edit</a>
                                </td>
                                <td>
                                    <form method="post"
                                        action="{{ route('subcategory.destroy', ['subcategory' => $subcategory->id]) }}"
                                        onsubmit="return confirmDelete('subcategory')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p>No subcategory yet</p>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
