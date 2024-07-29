@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add New Item</a>
    <ul class="list-group" id="itemList">
        @foreach($items as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center" id="item-{{ $item->id }}">
                <div>
                    <img src="/storage/{{ $item->image }}" alt="{{ $item->name }}" width="50" height="50" class="mr-3"> {{ $item->name }} ({{ $item->itemCategory->name }})
                </div>
                <div>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection