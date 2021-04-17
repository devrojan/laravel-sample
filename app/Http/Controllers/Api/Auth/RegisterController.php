<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Mail\UserVerified;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'min:4', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $data = $this->validator($request->all())->validate();
        $verificationCode = mt_rand(100000, 999999);

        $user = User::create([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'user_role' => 'user',
            'registered_at' => now(),
            'verification_code' => Hash::make($verificationCode)
        ]);

        Mail::to($user->email)->send(new UserVerified($user, $verificationCode));

        return $request->wantsJson()
                    ? new JsonResponse($user, 201)
                    : redirect($this->redirectPath());
    }
}
