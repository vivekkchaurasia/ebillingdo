@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Item</h1>
    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('items.partials.form', ['item' => $item])
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
