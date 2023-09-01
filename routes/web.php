<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/authorize', function () {
    $credentials = [
        'email' => 'example3@gmail.com',
        'password' => 'password',
    ];

    if (!Auth::attempt($credentials)) {
        $user = new User();

        $user->name = 'Admin3';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        $common_token = $user->createToken('common-token', ['none'])->plainTextToken;
        $inter_token = $user->createToken('inter-token', ['update', 'create'])->plainTextToken;
        $advance_token = $user->createToken('advance-token', ['create', 'update', 'delete'])->plainTextToken;

        return response()->json([
            "common_token" => $common_token,
            "inter_token" => $inter_token,
            "advance_token" => $advance_token,
        ]);
    };

    return 'YYYY';
});
