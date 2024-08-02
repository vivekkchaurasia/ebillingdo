@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Permission</h1>
    <form action="{{ route('user-permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Permission</button>
    </form>
</div>
@endsection
