<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function() {
//     Route::post('/send-invitation')
// });

// Route::post('/admin/login')

Auth::routes(['verify' => false]);

Route::post('/login', 'Api\Auth\LoginController@login');
Route::post('/register', 'Api\Auth\RegisterController@register');
Route::post('/verify', 'Api\Auth\VerificationController@verify');
Route::middleware('auth:sanctum')->post('/profile', 'Api\UserController@update');
