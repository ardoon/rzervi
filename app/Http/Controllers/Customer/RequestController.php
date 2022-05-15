<?php

namespace App\Http\Controllers\Customer;

use App\Events\BookingNotification;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use App\Services\Sms;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Request as RequestModel;

class RequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->requests;

        return Inertia::render('Customer/Request/Index', [
            'requests' => $requests
        ]);
    }

    public function create()
    {

        $user = auth()->user();
        $servers = $user->servers;
        return Inertia::render('Customer/Request/Create', [
            'servers' => $servers,
        ]);
    }

    public function get_services($server_id)
    {
        $server = Provider::where('id', $server_id)->first();
        return $server->services;
    }

    public function store(Request $request)
    {
        $attributes = Request::validate([
            'server' => 'required',
            'date' => 'required',
            'requester_comment' => '',
            'srvs' => 'required',
        ]);

        $date = Verta::parse($attributes['date'])->datetime();
        $services = json_encode($attributes['srvs']);

        $requestModel = RequestModel::create([
            'requester' => auth()->user()->id,
            'responder' => $attributes['server'],
            'requester_comment' => $attributes['requester_comment'],
            'services_ids' => $services,
            'date' => $date
        ]);

        $requestModel = RequestModel::where('id', $requestModel->id)->with('requester')->first();

        BookingNotification::dispatch($requestModel, 'responder', 'store');

        $responder = User::where('provider_id', '=', $attributes['server'])->first();

        $sms = new Sms($responder->phone, 'newRequest', [
            auth()->user()->first_name . ' ' . auth()->user()->last_name,
            $attributes['date']
        ]);

        $sms->send();

        return redirect('/customer/requests/');

    }

    public function edit(RequestModel $request)
    {
        $user = auth()->user();
        $servers = $user->servers;
        $server = Provider::where('id', $request->responder)->first();

        return Inertia::render('Customer/Request/Edit', [
            'servers' => $servers,
            'current_request' => $request,
            'allservices' => $server->services,
        ]);
    }

    public function update(RequestModel $request)
    {
        $attributes = Request::validate([
            'server' => 'required',
            'date' => 'required',
            'requester_comment' => '',
            'srvs' => 'required',
        ]);
        $date = Verta::parse($attributes['date'])->datetime();
        $services = json_encode($attributes['srvs']);

        $request->update([
            'requester' => auth()->user()->id,
            'responder' => $attributes['server'],
            'requester_comment' => $attributes['requester_comment'],
            'services_ids' => $services,
            'date' => $date
        ]);

        $request = RequestModel::where('id', $request->id)->with('requester')->first();

        BookingNotification::dispatch($request, 'responder', 'update');

        return redirect('/customer/requests/' . $request->id . '/edit');
    }

    public function cancel($id)
    {
        $request = RequestModel::where('id', $id)->with('requester')->first();
        if ($request->status === 'تایید شده') {
            $request->status = '4';
            $request->save();
        }

        BookingNotification::dispatch($request, 'responder', 'update');

        return redirect('/customer/requests/');
    }

    public function destroy(RequestModel $request)
    {
        $toDel = $request;

        BookingNotification::dispatch($toDel, 'responder', 'destroy');

        if ($request->status == 'لغو شده' or $request->status == 'رد شده') {
            $request->delete();
        }

        return redirect('/customer/requests/');
    }
}
