<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $credentials = $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|max:255|confirmed',
            ]);

            $user = User::create($credentials);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registered successfully!',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'ERROR',
                'error' => $th->getMessage(), // پیام خطا
                'file' => $th->getFile(),     // فایلی که خطا در آن رخ داده
                'line' => $th->getLine(),     // شماره خط
                // 'trace' => $th->getTrace(), // اگر نیاز به جزئیات بیشتر داری
            ], 500);
        }



    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records!'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged-in successfully!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged-out successfully!',
        ]);
    }

    public function user(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }
}
