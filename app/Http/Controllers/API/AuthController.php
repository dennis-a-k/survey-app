<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        /**
         * @var \App\Models\User $user
         */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            //Password1%
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'The Provided credentials are not correct',
            ], 422);
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout() {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
        ]);
    }
}
