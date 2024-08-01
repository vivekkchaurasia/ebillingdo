@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Roles</h1>
    <a href="{{ route('user-roles.create') }}" class="btn btn-primary mb-3">Add New Role</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                    <td>
                        <a href="{{ route('user-roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('user-roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
