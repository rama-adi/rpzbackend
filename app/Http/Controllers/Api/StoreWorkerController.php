<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreWorkerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('store_worker')) {
            return response()->json([
                'message' => 'successfully retrieved stores',
                'success' => true,
                'data' => $request->user()->stores->map(fn(Store $store) => [
                    'id' => $store->id,
                    'store' => $store->name,
                    'photo' => asset($store->image),
                    'foreground_color' => $store->foreground_color,
                    'background_color' => $store->background_color,
                    'created_at' => $store->created_at,
                ]),
            ]);
        } else {
            return response()->json([
                'message' => 'You are not logged in as a store worker.',
                'success' => false,
                'data' => []
            ], 401);
        }
    }
}
