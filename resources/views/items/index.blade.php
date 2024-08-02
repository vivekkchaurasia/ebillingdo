@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add New Item</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Img</th>
                <th>Category</th>
                <th>Item Name</th>
                <th>Serial No.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="list-group-item d-flex justify-content-between align-items-center" id="item-{{ $item->id }}"><a href="/storage/{{ $item->image }}" target="_blank"><img src="/storage/{{ $item->image }}" alt="{{ $item->name }}" width="120" height="80" class="mr-3"></a></td>
                    <td>{{ $item->itemCategory->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->serial_no }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>                
                </tr>
            @endforeach
        <tbody>
    </table>
</div>
@endsection