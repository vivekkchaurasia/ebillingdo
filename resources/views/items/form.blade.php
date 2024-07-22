@extends('layouts.app')

@section('title', isset($item) ? 'Edit Item' : 'Add Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ isset($item) ? 'Edit Item' : 'Add Item' }}</h1>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
</div>

<form action="{{ isset($item) ? route('items.update', $item->id) : route('items.store') }}" method="POST">
    @csrf
    @if (isset($item))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="item_category_id" class="form-label">Item Category</label>
        <select class="form-select" id="item_category_id" name="item_category_id" required>
            @foreach ($itemCategories as $category)
                <option value="{{ $category->id }}" {{ isset($item) && $item->item_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Item Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($item) ? $item->name : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="serial_name" class="form-label">Serial Name</label>
        <input type="text" class="form-control" id="serial_name" name="serial_name" value="{{ isset($item) ? $item->serial_name : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="serial_no" class="form-label">Serial No.</label>
        <input type="text" class="form-control" id="serial_no" name="serial_no" value="{{ isset($item) ? $item->serial_no : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="opening_stock" class="form-label">Opening Stock</label>
        <input type="number" class="form-control" id="opening_stock" name="opening_stock" value="{{ isset($item) ? $item->opening_stock : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="wholesale_price" class="form-label">Wholesale Price</label>
        <input type="number" step="0.01" class="form-control" id="wholesale_price" name="wholesale_price" value="{{ isset($item) ? $item->wholesale_price : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="retail_price" class="form-label">Retail Price</label>
        <input type="number" step="0.01" class="form-control" id="retail_price" name="retail_price" value="{{ isset($item) ? $item->retail_price : '' }}" required>
    </div>

    <button type="submit" class="btn btn
