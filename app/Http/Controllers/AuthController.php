<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:255|confirmed',
        ]);

        $user = User::create($credentials);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);

    }

    public function login()
    {
    }

    public function logout()
    {
    }

    public function user()
    {
    }
}
