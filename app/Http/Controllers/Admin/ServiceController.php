<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

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

        return Inertia::render('Admin/Service/Index', [
            'services' => $services
        ]);

    }

    public function create()
    {
        return Inertia::render('Admin/Service/Create');
    }

    public function store()
    {
        $attributes = Request::validate([
            'name' => 'required',
            'gender' => 'required',
        ]);

        Service::create($attributes);

        return redirect('/admin/services');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Admin/Service/Edit', [
            'current_service' => $service
        ]);
    }

    public function update(Service $service)
    {
        $attributes = Request::validate([
            'name' => 'required',
            'gender' => 'required',
        ]);

        $service->update($attributes);

        return redirect('/admin/services/' . $service->id . '/edit');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect('/admin/services');
    }

}
