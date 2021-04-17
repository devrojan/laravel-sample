<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        $emailOrUsername = filter_var($credential['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!Auth::attempt([$emailOrUsername => $credential['username'], 'password' => $credential['password']])) {
            return response()->json(['message' => 'Invalid Credentials'], 400);
        }

        $user = auth()->user();

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'You need to verify your account first'], 401);
        }

        $this->incrementLoginAttempts($request);
        return response()->json(['token' => $user->createToken($user->id . '_API_TOKEN')->plainTextToken]);
    }
}
