<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loyalty;
use Illuminate\Http\Request;

class UserLoyaltyController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'successfully retrieved stores',
            'success' => true,
            'data' => $request->user()->loyalties->map(fn(Loyalty $loyalty) => [
                'id' => $loyalty->id,
                'store' => $loyalty->store->name,
                'photo' => asset("storage/".$loyalty->store->image),
                'points' => $loyalty->points,
                'foreground_color' => $loyalty->store->foreground_color,
                'background_color' => $loyalty->store->background_color,
                'created_at' => $loyalty->created_at,
            ]),
        ]);
    }


}
