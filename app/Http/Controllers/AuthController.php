<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'confirm_password' => 'required',
            ]);

            if ($request->password != $request->confirm_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Passwords do not match.',
                ], 409);
            }

            $user_exists = User::where('email', $request->email)->first();

            if ($user_exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'There already exists an user with this email.',
                ], 409);
            }

            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'roles'     => $request->roles,
                'isActive'  => true,
                'tel'       => $request->tel,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User has created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()
            ->json([
                'success' => true,
                'message' => 'Login successful',
            ], 200)
            ->cookie('access_token', $token, 60 * 24 * 7, '/', null, false, true);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $newToken = $user->createToken('authToken')->plainTextToken;

        return response()->json(['message' => 'Token refreshed'])->cookie(
            'access_token',
            $newToken,
            60 * 24 * 7,
            null,
            null,
            true,
            true
        );
    }

    public function me()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token or expired'], 401);
        }

        return response()->json(compact('user'));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'])->withoutCookie('access_token');
    }
}
