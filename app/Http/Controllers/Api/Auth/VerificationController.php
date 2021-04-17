<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'verification_code' => 'required'
        ]);

        $user = User::findOrFail($request->id);

        if (!Hash::check($request->verification_code, $user->verification_code)) {
            return response()->json(['message' => 'Incorrect verification code'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return new JsonResponse([
                'verified' => 'true',
                'message' => 'Account is already verified'
            ], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return new JsonResponse([
            'verified' => 'true',
            'message' => 'Account verified'
        ], 200);
    }
}
