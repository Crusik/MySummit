<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request -> email) -> first();

            if (!$user || !Hash::check($request -> password, $user -> password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return response()->json([
                'token' => $user -> createToken('auth-token') -> plainTextToken,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage() . ' ' . $e -> getTraceAsString());
            return response() -> json(['error' => $e -> getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user() -> currentAccessToken() -> delete();

        return response() -> json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response() -> json($request -> user());
    }
}
