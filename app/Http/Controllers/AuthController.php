<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        //to create RegisterRequest i wrote in command line "php artisan make:request RegisterRequest"
        //automaticly check the filed that we sending for validation

        $pasword = Hash::make($request['password']);

        //generage automaticly "userName" from email that we will send


        $user = User::create([
            'email' => $request->email,
            'password' => $pasword,
            'user_name' => $request->user_name
        ]);

        $token = $user->createToken('register-token')->plainTextToken; //we need that our user model extends Authenticatable, and than this line created token


        return response([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }


    public function login(LoginRequest $request)
    {


        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return response(['success' => false, "message" => 'user does not exists']);
        }

        if (!Hash::check($request['password'], $user['password'])) {
            return response(['success' => false, 'password error']);
        }

        return response([
            'success' => true,
            'user' => $user,
            'token' => $user->createToken('login-token')->plainTextToken
        ]);
    }

    public function check_token(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response(['success' => true, 'user' => $user]);
        }

        return response(['success' => false, 'no token']);
    }

    public function log_out(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();

        return response(['success' => true]);
    }
}
