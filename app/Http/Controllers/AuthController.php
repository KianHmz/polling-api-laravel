<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registered successfully!',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|max:255'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials do not match our records!'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Logged-in successfully!',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged-out successfully!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function user(Request $request)
    {
        try {
            return response()->json($request->user());

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
