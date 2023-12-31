<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
        $this->expired = config('auth.passwords.'.config('auth.defaults.passwords').'.expire') * 60; //60seconds x 60 minutes
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');
        $email = $request->email;

        $existToken = DB::table('password_resets')->where('email', $email)->first();

        if(!$existToken){
            abort(419);
        }

        $checkToken = $this->hasher->check($token, $existToken->token);

        if(!$checkToken) {
            abort(419);
        }

        $expiredToken = Carbon::parse($existToken->created_at)->addSeconds($this->expired)->isPast();

        if($expiredToken) {
            abort(419);
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'confirmed'],
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'password.required' => 'Sila isikan kata laluan',
            'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara',
            'password.regex' => 'Kata laluan tidak sah',
            'password.confirmed' => 'Pengesahan kata laluan tidak sepadan',
        ];
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

}
