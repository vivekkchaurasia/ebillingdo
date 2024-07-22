@extends('layouts.app')

@section('title', isset($itemCategory) ? 'Edit Item Category' : 'Add Item Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ isset($itemCategory) ? 'Edit Item Category' : 'Add Item Category' }}</h1>
    <a href="{{ route('item-categories.index') }}" class="btn btn-secondary">Back</a>
</div>

<form action="{{ isset($itemCategory) ? route('item-categories.update', $itemCategory->id) : route('item-categories.store') }}" method="POST">
    @csrf
    @if (isset($itemCategory))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($itemCategory) ? $itemCategory->name : '' }}" required>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($itemCategory) ? 'Update' : 'Add' }}</button>
</form>
@endsection
