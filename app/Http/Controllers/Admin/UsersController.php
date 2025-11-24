<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|string|in:user,admin',
        ]);

        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('success','User role updated');
    }
}
