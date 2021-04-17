<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'avatar' => 'dimensions:min_width=250,min_height=250,max_width=250,max_height=250'
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->save();

        return $user;
    }
}
