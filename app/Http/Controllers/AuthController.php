<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only(['email','password']))){
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details.',
                'data' => []
            ],401);
        }
        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User authenticated.',
            'data' => ['token' => $token]
        ],200);
    }
}
