@extends('admin.dashboard_layout')
@section('title', 'Products Size')
@section('content')
    <div class="text-center my-3">
        <h1>Add Size</h1>
    </div>
    <div class="row justify-content-center">
        <form class="form-group" method="POST" action="{{ route('size.store') }}">
            @csrf
            <div class="form-group ">
                <input type="text" name='name' id="name" placeholder="Size " required>
            </div>
            <div class="form-group ">
                <input type="text" name='abbreviation' id="abbreviation" placeholder="abbreviation " >
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add</button>
        </form>
    </div>
    <div class="text-center my-3">
        <h1> Sizes</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Abbreviation</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($sizes))
                        @forelse ($sizes as $size)
                            <tr>
                                <td>{{ $size->name }}</td>
                                <td>{{ $size->abbreviation }}</td>
                                <td>
                                    <form method="post" action="{{ route('size.destroy', ['size' => $size->id]) }}"
                                        onsubmit="return confirmDelete('size')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <p>No size yet</p>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
