<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $provider = auth()->user()->provider;

        $users = $provider->customers;

        return Inertia::render('Provider/User/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Provider/User/Create');
    }

    public function store()
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $provider = auth()->user()->provider;

        if (!User::where('phone', '=', $attributes['phone'])->exists()) {
            $user = User::create($attributes);
        } else {
            $user = User::where('phone', '=', $attributes['phone'])->first();
        }

        $provider->customers()->attach($user->id);

        return redirect('/provider/users');
    }

    public function edit(User $user)
    {
        return Inertia::render('Provider/User/Edit', [
            'current_user' => $user
        ]);
    }

    public function update(User $user)
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $attributes = array_filter($attributes);

        $user->update($attributes);

        return redirect('/provider/users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
        $provider = auth()->user()->provider;

        $provider->customers()->detach($user->id);

        return redirect('/provider/users');
    }

}
