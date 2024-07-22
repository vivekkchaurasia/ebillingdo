@extends('layouts.app')

@section('title', 'Items')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary">Add New Item</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Name</th>
            <th>Serial Name</th>
            <th>Serial No.</th>
            <th>Opening Stock</th>
            <th>Wholesale Price</th>
            <th>Retail Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->itemCategory->name }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->serial_name }}</td>
            <td>{{ $item->serial_no }}</td>
            <td>{{ $item->opening_stock }}</td>
            <td>{{ $item->wholesale_price }}</td>
            <td>{{ $item->retail_price }}</td>
            <td>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
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
