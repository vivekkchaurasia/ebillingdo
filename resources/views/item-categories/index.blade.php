@extends('layouts.app')

@section('title', 'Item Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Item Categories</h1>
    <a href="{{ route('item-categories.create') }}" class="btn btn-primary">Add New Category</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($itemCategories as $itemCategory)
        <tr>
            <td>{{ $itemCategory->id }}</td>
            <td>{{ $itemCategory->name }}</td>
            <td>
                <a href="{{ route('item-categories.edit', $itemCategory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('item-categories.destroy', $itemCategory->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
