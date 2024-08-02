<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('id', '!=', 1)->orderBy('name', 'asc')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $roleIds = $request->input('roles', []);
        $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
        $user->assignRole($roleNames);
        
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        if ($id==1) {
            return redirect()->route('users.index')->with('error', 'This user cannot be edited.');
        }
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        $roleIds = $request->input('roles', []);
        $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        if (in_array($id, [1, 2])) {
            return redirect()->route('users.index')->with('error', 'This user cannot be deleted.');
        }

        User::destroy($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
