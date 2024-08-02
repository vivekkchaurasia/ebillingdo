@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Create Item</h1>
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('items.partials.form')
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>
@endsection