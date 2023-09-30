<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        if ($request->validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $request->validator->errors(),
            ], 422);
        }

        $payload = $request->only('name', 'email', 'password', 'category_id');
        $payload['password'] = Hash::make($payload['password']);
        $payload['uuid'] = Uuid::uuid4()->toString();

        try {
            //code...
            $user = User::create($payload);
            $payloadLogin = $request->only('email', 'password');
            if (auth()->attempt($payloadLogin)) {
                $user = auth()->user();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ], 200);
            }

            throw new \Exception('Server error');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'errors' => 'Internal server error ' . $th->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        if ($request->validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $request->validator->errors(),
            ], 422);
        }

        $payload = $request->only('email', 'password');

        if (auth()->attempt($payload)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'data' => [
                    'user' => Auth::user(),
                    'token' => $token
                ]
            ], 200);
        }

        return response()->json([
            'status' => false,
            'errors' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Token deleted successfully'
        ], 200);
    }

    public function notAuthorized()
    {
        return response()->json([
            'status' => false,
            'errors' => 'You are not authorized to access this resource'
        ], 401);
    }
}
