<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('/getTodoToken', function(){
    $user = User::first();
    $token = $user->createToken('todoAuthToken')->accessToken;
    return response()->json([
        'time'  => date('d/m/y h:i:s A'),
        'token' => $token,
        'user'  => $user
    ]);
    return $token;
});

Route::middleware(['auth:api'])->group(function(){
    Route::post('/getTodoUser', function(){
        $user = User::first();
        return response()->json([
            'time'  => date('d/m/y h:i:s A'),
            'user'  => $user
        ]);
    });
});