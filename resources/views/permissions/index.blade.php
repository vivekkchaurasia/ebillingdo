@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Permissions</h1>
    <a href="{{ route('user-permissions.create') }}" class="btn btn-primary mb-3">Add New Permission</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{ route('user-permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('user-permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
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
