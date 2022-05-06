<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $servers = $user->servers;

        return Inertia::render('Customer/Server/Index', [
            'servers' => $servers
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->gender === 'male') {

            $providers = Provider::where('type', 'پیرایش مردانه')->get();

        } else {

            $providers = Provider::where('type', '!=', 'پیرایش مردانه')->get();

        }

        return Inertia::render('Customer/Server/Create', [
            'providers' => $providers
        ]);
    }

    public function join($id)
    {
        $user = auth()->user();

        $user->servers()->attach($id);

        return redirect()->route('customer.servers');
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $user->servers()->detach($id);

        return redirect()->route('customer.servers');

    }
}
