<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendInvitationController extends Controller
{
    public function create(Request $request)
    {
        $admin = auth()->user();

        Mail::to($request->email)->send(new AdminInvited());
    }
}
