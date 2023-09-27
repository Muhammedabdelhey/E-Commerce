@extends('admin.dashboard_layout')
@section('title', 'Products color')
@section('content')
    <div class="text-center my-3">
        <h1>Add color</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-inline" method="POST" action="{{ route('color.store') }}">
            @csrf
            <div class="form-group mx-sm-3 mb-2 my-3">
                <input type="text" name='name' id="name" placeholder="color " required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add</button>
        </form>
    </div>
    <div class="text-center my-3">
        <h1> colors</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($colors))
                        @forelse ($colors as $color)
                            <tr>
                                <td>{{ $color->name }}</td>
                                <td>
                                    <form method="post" action="{{ route('color.destroy', ['color' => $color->id]) }}"
                                        onsubmit="return confirmDelete('color')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p>No colors yet</p>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
