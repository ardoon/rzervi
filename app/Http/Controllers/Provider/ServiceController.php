<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {

        $provider = auth()->user()->provider;

        $services = $provider->services;

        foreach ($services as $service) {
            switch ($service->gender) {
                case 'female':
                    $service->gender = 'بانوان';
                    break;
                case 'male':
                    $service->gender = 'مردان';
                    break;
                case 'both':
                    $service->gender = 'بدون محدودیت جنسی';
                    break;
            }
        }

        return Inertia::render('Provider/Service/Index', [
            'services' => $services
        ]);

    }

    public function create()
    {

        $provider = auth()->user()->provider;

        if ($provider->type === 'پیرایش مردانه') {

            $services = Service::where('gender', '!=', 'female')->get();

        } else {

            $services = Service::where('gender', '!=', 'male')->get();

        }


        foreach ($services as $service) {
            switch ($service->gender) {
                case 'female':
                    $service->gender = 'بانوان';
                    break;
                case 'male':
                    $service->gender = 'مردان';
                    break;
                case 'both':
                    $service->gender = 'بدون محدودیت جنسی';
                    break;
            }
        }

        return Inertia::render('Provider/Service/Create', [
            'services' => $services
        ]);
    }

    public function store()
    {
        $attributes = Request::validate([
            'service_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $provider = auth()->user()->provider;

        $provider->services()->attach($attributes['service_id'], ['price' => $attributes['price'], 'description' => $attributes['description']]);

        return redirect('/provider/services');
    }

    public function edit($service_id)
    {

        $provider = auth()->user()->provider;

        if ($provider->type === 'پیرایش مردانه') {

            $services = Service::where('gender', '!=', 'female')->get();

        } else {

            $services = Service::where('gender', '!=', 'male')->get();

        }

        foreach ($services as $srv) {
            switch ($srv->gender) {
                case 'female':
                    $srv->gender = 'بانوان';
                    break;
                case 'male':
                    $srv->gender = 'مردان';
                    break;
                case 'both':
                    $srv->gender = 'بدون محدودیت جنسی';
                    break;
            }
        }

        $service = $provider->services->where('id', $service_id)->first()->pivot;

        return Inertia::render('Provider/Service/Edit', [
            'current_service' => $service,
            'services' => $services
        ]);
    }

    public function update($service_id)
    {
        $attributes = Request::validate([
            'service_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $provider = auth()->user()->provider;

        // TODO: refactor
        $provider->services->where('id', $service_id)->first()->pivot->service_id = $attributes['service_id'];
        $provider->services->where('id', $service_id)->first()->pivot->price = $attributes['price'];
        $provider->services->where('id', $service_id)->first()->pivot->description = $attributes['description'];
        $provider->services->where('id', $service_id)->first()->pivot->save();


        return redirect('/provider/services/' . $attributes['service_id'] . '/edit');
    }

    public function destroy($service_id)
    {
        $provider = auth()->user()->provider;

        $provider->services()->detach($service_id);

        return redirect('/provider/services');
    }
}
