<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class PropertyController extends Controller
{
    public function get_properties(): JsonResponse
    {
        try {
            $properties = Property::all();

            return response()->json([
                'success' => true,
                'data' => $properties,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching properties.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_property($id): JsonResponse
    {
        try {
            $property = Property::find($id);

            return response()->json([
                'success' => true,
                'data' => $property,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching properties.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create_property(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required',
                'address' => 'required',
                'type' => 'required',
            ]);

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => "You can't create a property if you aren't logged in."
                ], 401);
            }

            Property::create([
                'title' => $request->title,
                'address' => $request->address,
                'description' => $request->description,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'images' => $request->images,
                'type' => $request->type,
                'status' => $request->status,
                'is_active' => true,
                'price' => $request->price,
                'area' => $request->area,
                'beds' => $request->beds,
                'baths' => $request->baths,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property created was successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_property(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'lat' => 'nullable|numeric',
                'lng' => 'nullable|numeric',
                'images' => 'nullable|array',
                'images.*' => 'string|url',
                'type' => 'nullable|string',
                'status' => 'nullable|string',
                'price' => 'nullable|numeric',
                'area' => 'nullable|numeric',
                'beds' => 'nullable|numeric',
                'baths' => 'nullable|numeric',
            ]);

            $filteredData = array_filter($validated, fn($value) => !is_null($value));

            $property = Property::find($id);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found'
                ], 404);
            }

            $property->update($filteredData);

            return response()->json([
                'success' => true,
                'message' => 'Property has updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function property_availability(Request $request, $id): JsonResponse
    {
        try {
            $message = '';
            $property = Property::find($id);

            if($property->is_active)
            {
                $this->$message = 'Property has been unactivated.';
            } else 
            {
                $this->$message = 'Property has been activated.';
            }

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found'
                ], 404);
            }

            $property->update(['is_active' => !$property->is_active]);

            return response()->json([
                'success' => true,
                'message' => $this->$message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
