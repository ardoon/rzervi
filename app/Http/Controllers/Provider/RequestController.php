<?php

namespace App\Http\Controllers\Provider;

use App\Events\BookingNotification;
use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->provider->requests;

        return Inertia::render('Provider/Request/Index', [
            'requests' => $requests
        ]);
    }

    public function show(RequestModel $request)
    {
        $services = Service::whereIn('id', $request->services_ids)->get();
        return Inertia::render('Provider/Request/Show', [
            'current_request' => $request->load('requester'),
            'services' => $services
        ]);
    }

    public function cancel(Request $req, RequestModel $request)
    {
        $request->status = '3';
        $request->responder_comment = $req->comment;
        $request->save();
        $request = RequestModel::where('id', $request->id)->with('responder')->first();
        BookingNotification::dispatch($request, 'requester', 'update');
        return redirect('/provider/requests/');

    }

    public function accept(Request $req, RequestModel $request)
    {
        $request->status = '2';
        $request->responder_comment = $req->comment;
        $request->save();
        $request = RequestModel::where('id', $request->id)->with('responder')->first();
        BookingNotification::dispatch($request, 'requester', 'update');
        return redirect('/provider/requests/');
    }

    public function destroy(RequestModel $request)
    {
        BookingNotification::dispatch($request, 'requester', 'destroy');

        if ($request->status == 'لغو شده') {
            $request->delete();
        }

        return redirect('/provider/requests/');
    }
}
