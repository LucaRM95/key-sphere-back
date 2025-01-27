<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function update_user(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'lastname' => 'nullable|string|max:255',
                //'password' => 'nullable|string|min:8',
                'roles' => 'nullable|string',
                'is_active' => 'nullable|boolean',
                'email' => 'nullable|email|max:255',
                'email_verified_at' => 'nullable|date',
                'image' => 'nullable|url',
                'tel' => 'nullable|string|max:20',
            ]);

            $filteredData = array_filter($validated, fn($value) => !is_null($value));

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }

            $user->update($filteredData);

            return response()->json([
                'success' => true,
                'message' => 'You profile has been updated.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function add_favorites(Request $request)
    {
        try {
            $request->validate([
                'fid' => 'required|uuid',
            ]);

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }

            $property = Property::find($request->fid);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only add an existing property.'
                ], 409);
            }

            if (in_array($request->fid, $user->favorites ?? [])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This property is already in your favorites.'
                ], 409);
            }

            $user->favorites = array_merge($user->favorites ?? [], [$request->fid]);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Property added to favorites.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function remove_favorite(Request $request)
    {
        try {
            $request->validate([
                'fid' => 'required|uuid',
            ]);

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }

            if (!in_array($request->fid, $user->favorites ?? [])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This property is not in your favorites.'
                ], 409);
            }

            $user->favorites = array_filter($user->favorites ?? [], fn($id) => $id != $request->fid);
            $user->favorites = array_values($user->favorites);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Property removed from favorites.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
