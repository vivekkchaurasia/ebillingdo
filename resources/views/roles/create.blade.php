@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Create New Role</h1>
    <form action="{{ route('user-roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="permissions">Assign Permissions</label>
            <select class="form-control" id="permissions" name="permissions[]" multiple multiple size="10">
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Role</button>
    </form>
</div>
@endsection
