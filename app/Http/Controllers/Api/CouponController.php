<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Loyalty;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function show(Loyalty $loyalty)
    {
        return response()->json([
            'message' => 'successfully retrieved coupons',
            'success' => true,
            'data' => $loyalty->coupons->map(fn(Coupon $coupon) => [
                'id' => $coupon->id,
                'code' => "{$coupon->store_id}_{$coupon->code}",
                'title' => $coupon->title,
                'description' => $coupon->description,
                'created_at' => $coupon->created_at,
                'redeemed_at' => $coupon->redeemed_at,
            ]),
        ]);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
            ]);

            [$store_id, $code] = explode('_', $request->input('code'));

            $coupon = Coupon::whereStoreId($store_id)
                ->whereCode($code)
                ->first();

            if (!$coupon) {
                return response()->json([
                    'message' => 'coupon not found',
                    'success' => false,
                    'data' => []
                ], 404);
            }

            if ($coupon->redeemed_at == null) {
                $coupon->update([
                    'redeemed_at' => now(),
                ]);

                return response()->json([
                    'message' => 'coupon redeemed',
                    'success' => true,
                    'data' => [
                        'id' => $coupon->id,
                        'code' => "{$coupon->store_id}_{$coupon->code}",
                        'title' => $coupon->title,
                        'description' => $coupon->description,
                        'created_at' => $coupon->created_at,
                    ]
                ]);
            }

            return response()->json([
                'message' => 'coupon already redeemed',
                'success' => false,
                'data' => []
            ], 400);
        } catch (Exception) {
            return response()->json([
                'message' => 'Invalid or non-existent coupon code',
                'success' => false,
                'data' => []
            ], 500);
        }
    }
}
