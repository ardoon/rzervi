<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Auth/ResetPassword', [
            'phone' => $request->phone,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone' => 'required|numeric',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $token = DB::table('password_resets')
            ->where('phone', '=', $request->phone)
            ->orderBy('created_at', 'desc')->first();

        if (!is_null($token)) {
            $time = Carbon::parse($token->created_at);
            if ((Carbon::now())->lt($time->addMinutes(15)) && ($token->token === $request->token) ) {
                $user = User::where('phone', '=', $request->phone)->first();
                $user->update([
                    'password' => $request->password
                ]);
                DB::table('password_resets')->where('phone', '=', $request->phone)->delete();
                return redirect()->route('login')->with('status','گذرواژه جدید ثبت شد!');
            }
        }

        throw ValidationException::withMessages([
            'phone' => [trans('passwords.token')],
        ]);
    }
}
