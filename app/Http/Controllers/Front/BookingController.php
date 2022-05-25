<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function create(Provider $provider)
    {
        if (session()->has('book_info')) {
            $data = json_decode(session('book_info'));
            if ($data->server !== $provider->id) {
                $data = null;
            }
        }

        return Inertia::render('Front/BookCreate', [
            'provider' => $provider,
            'data' => $data ?? null
        ]);
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'server' => 'required|numeric',
            'date' => 'required|string',
            'srvs' => 'required|array',
        ]);

        session(['book_info' => json_encode($data)]);

        $provider = $data['provider'] = Provider::where('id', $data['server'])->first();

        if (Auth::check()) {

            $data['user'] = auth()->user();

        }

        $data['services'] = $provider->services->whereIn('id', $data['srvs']);

        $data['total'] = 0;
        foreach ($data['services'] as $service) {
            $data['total'] += $service->pivot->price;
        }

        // todo: here we should check if payment needed!

        return Inertia::render('Front/BookCheckout', $data);

    }

}
