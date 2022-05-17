<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Sms;
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
            'phone' => 'required',
        ]);

        $provider = auth()->user()->provider;

        if (!User::where('phone', '=', $attributes['phone'])->exists()) {
            $password = $this->generate_password();
            $user = User::create([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'gender' => $attributes['gender'],
                'type' => $attributes['type'],
                'phone' => $attributes['phone'],
                'password' => $password
            ]);
            $sms = new Sms($attributes['phone'], 'newCustomer', [
                $user->first_name . ' ' . $user->last_name,
                $provider->title,
                $attributes['phone'],
                $password
            ]);
            $sms->send();
        } else {
            $user = User::where('phone', '=', $attributes['phone'])->first();
            $sms = new Sms($attributes['phone'], 'addCustomer', [
                $user->first_name . ' ' . $user->last_name,
                $provider->title
            ]);
            $sms->send();
        }

        $customer = $provider->customers()->where('user_id', $user->id)->first();

        if (is_null($customer)){
            $provider->customers()->attach($user->id);
        }

        return redirect('/provider/users');
    }

    public function edit(User $user)
    {
        $canEdit = true;

        if ($user->hasVerifiedPhone())
            $canEdit = false;

        return Inertia::render('Provider/User/Edit', [
            'current_user' => $user,
            'canEdit' => $canEdit
        ]);
    }

    public function update(User $user)
    {
        $attributes = \Illuminate\Support\Facades\Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
        ]);
        if ($user->hasVerifiedPhone())
            $user->update($attributes);

        return redirect('/provider/users/' . $user->id . '/edit');
    }

    public function destroy(User $user)
    {
        $provider = auth()->user()->provider;

        if ($user->hasVerifiedPhone())
            $provider->customers()->detach($user->id);

        return redirect('/provider/users');
    }

    public function generate_password($length = 8): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
            '0123456789=!@#$%&*+?';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }

}
