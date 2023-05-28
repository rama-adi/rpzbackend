<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreWorker;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data' => []
            ], 401);
        }

        if (
            $request->exists('store_worker')
            && StoreWorker::whereUserId(auth()->user()->id)->doesntExist()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a worker of any store',
                'data' => []
            ], 401);
        }


        $token = auth()->user()->createToken('auth_token', [
            $request->exists('store_worker')
                ? 'store_worker'
                : 'customer',
        ])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successfull',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'type' => $request->exists('store_worker')
                    ? 'store_worker'
                    : 'customer'
            ]
        ]);
    }
}
