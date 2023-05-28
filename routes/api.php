<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('my')->group(function () {
    Route::get('data', function () {
        return response()->json([
            'success' => true,
            'message' => 'successfully retrieved user data',
            'data' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]
        ]);
    });
    Route::get('loyalties', [\App\Http\Controllers\Api\UserLoyaltyController::class, 'index']);
    Route::get('loyalties/{loyalty}/coupons', [\App\Http\Controllers\Api\CouponController::class, 'show']);
    Route::post('/coupon/redeem', [\App\Http\Controllers\Api\CouponController::class, 'update']);

    Route::get('stores', [\App\Http\Controllers\Api\StoreWorkerController::class, 'index']);
});
