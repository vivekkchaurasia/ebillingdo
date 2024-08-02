@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Edit Role</h1>
    <form action="{{ route('user-roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
        </div>
        <div class="form-group">
            <label for="permissions">Assign Permissions</label>
            <select class="form-control" id="permissions" name="permissions[]" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>
@endsection
