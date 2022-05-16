<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->load('avatar');

        return Inertia::render('Admin/User/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/User/Create');
    }

    public function store()
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        User::create($attributes);

        return redirect('/admin/users');
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/User/Edit', [
            'current_user' => $user
        ]);
    }

    public function update(User $user)
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $attributes = array_filter($attributes);

        $user->update($attributes);

        return redirect('/admin/users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/users');
    }
}
