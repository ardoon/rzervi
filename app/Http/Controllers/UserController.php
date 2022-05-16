<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(User $user)
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $attributes = array_filter($attributes);

        $user->update($attributes);

        return back();
    }
}
