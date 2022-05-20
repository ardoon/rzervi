<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProviderController extends Controller
{
    public function show(Provider $provider)
    {
        return Inertia::render('Front/ProviderShow', [
            'provider' => $provider,
        ]);
    }
}
