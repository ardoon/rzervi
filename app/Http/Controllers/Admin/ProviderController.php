<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProviderController extends Controller
{

    public function index()
    {
        $providers = Provider::all();

        return Inertia::render('Admin/Provider/Index', [
            'providers' => $providers
        ]);
    }

    public function create()
    {
        $users = User::all();
        return Inertia::render('Admin/Provider/Create',['users' => $users]);
    }

    public function store()
    {

        $attributes = Request::validate([
            'title' => 'required',
            'type' => 'required',
            'slug' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'user_id' => 'required',
        ]);

        $user = User::where('id', request('user_id'))->first();

        $provider = Provider::create($attributes);

        $user->provider()->associate($provider);

        $user->save();

        return redirect('/admin/providers');
    }

    public function edit(Provider $provider)
    {
        $user = $provider->users()->first();
        $provider->user_id = $user->id;

        $users = User::all();

        return Inertia::render('Admin/Provider/Edit', [
            'current_provider' => $provider,
            'users' => $users,
        ]);
    }

    public function update(Provider $provider)
    {
        $attributes = Request::validate([
            'title' => 'required',
            'type' => 'required',
            'slug' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'user_id' => 'required',
        ]);


        $provider->update($attributes);

        // DELETE RELATION BETWEEN PROVIDER AND USERS
        $old_users = User::where('provider_id', $provider->id)->get();
        foreach ($old_users as $usr){
            $usr->provider_id = null;
            $usr->save();
        }

        // Assign User to Provider
        $user = User::where('id', request('user_id'))->first();
        $user->provider()->associate($provider);
        $user->save();

        return redirect('/admin/providers/' . $provider->id . '/edit');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect('/admin/providers');
    }
}
