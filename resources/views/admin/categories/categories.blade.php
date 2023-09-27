@extends('admin.dashboard_layout')
@section('title', ' Catagories')
@section('content')
    <div class="text-center my-3">
        <h1> Catagories</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($categories))
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td><a class="btn btn-primary"
                                        href="{{ route('categories.edit', ['category' => $category->id]) }}">Edit</a></td>
                                <td>
                                    <form method="post"
                                        action="{{ route('categories.destroy', ['category' => $category->id]) }}"
                                        onsubmit="return confirmDelete('Category')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p>No Category yet</p>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
