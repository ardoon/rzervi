<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class VerifyPhoneController extends Controller
{

    public function create(Request $request)
    {
        $user = auth()->user();
        $time = null;

        if ($this->session_needs_to_regenerate()) {
            $this->generate_session();
            $sms = new Sms($user->phone, 'welcome', [
                $user->first_name . ' ' . $user->last_name,
                session('phone_code.code')
            ]);
            $sms->send();

        }

        $time = session('phone_code.time')->diffInSeconds();

        return Inertia::render('Auth/VerifyPhone', [
            'name' => $user->first_name . ' ' . $user->last_name,
            'phone' => $user->phone,
            'time' => $time,
        ]);
    }

    public function generate_code(): int
    {
        $digits = 5;
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

    public function generate_session()
    {
        $value = [
            'code' => $this->generate_code(),
            'time' => Carbon::now()->addSeconds(120)
        ];
        Session::put(['phone_code' => $value]);
    }

    public function session_needs_to_regenerate()
    {
        return !Session::exists('phone_code') || ! session('phone_code.time')->gt(Carbon::now());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:5',
        ]);

        $user = auth()->user();

        if(Session::exists('phone_code') && session('phone_code.time')->gt(Carbon::now()) && session('phone_code.code') === (int) $request->code) {
            $user->phone_verified_at = Carbon::now();
            $user->save();

            return redirect('dashboard');
        }

        return back()->withErrors('کد وارد شده نامعتبر است');
    }

}
