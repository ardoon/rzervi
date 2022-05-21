<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function create(Provider $provider)
    {
        return Inertia::render('Front/BookCreate', [
            'provider' => $provider
        ]);
    }
}
