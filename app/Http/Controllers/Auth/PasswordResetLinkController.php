<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
        ]);

        $user = User::where('phone', '=', $request->phone)->first();
        $status = '';

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'phone' => [trans('passwords.user')],
            ]);
        }

        $old_token = DB::table('password_resets')
            ->where('phone', '=', $request->phone)
            ->orderBy('created_at', 'desc')->first();

        if (!is_null($old_token)) {
            $time = Carbon::parse($old_token->created_at);
            if ((Carbon::now())->lt($time->addMinutes(15))) {
                $diff = $time->diffInMinutes();
                return back()->with('status','لینک بازیابی قبلا ارسال شده است، ' . $diff . ' دقیقه دیگر لینک بازیابی معتبر است.');
            }
        }

        $token = $this->generate_token();

        DB::table('password_resets')->where('phone', '=', $request->phone)->delete();

        DB::table('password_resets')->insert(
            [
                'phone'     =>   $request->phone,
                'token'   => $token,
                'created_at' => Carbon::now()
            ]
        );

        $reset_link = url('/') . '/reset-password/' . $token;

        $sms = new Sms($request->phone, 'resetPassword', [
            $user->first_name . ' ' . $user->last_name,
            $reset_link
        ]);

        $sms->send();

        return back()->with('status', __('passwords.sent'));

    }

    public function generate_token($length = 10): string
    {
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i=0; $i < $length; $i++)
            $str .= $chars[random_int(0, $max)];

        return $str;
    }
}
