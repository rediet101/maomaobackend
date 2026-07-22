<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuOrderRequest;
use App\Http\Resources\MenuOrderResource;
use App\Models\MenuItem;
use App\Models\MenuOrder;
use Illuminate\Http\JsonResponse;

class MenuOrderController extends Controller
{
    public function store(StoreMenuOrderRequest $request): JsonResponse
    {
        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        $order = MenuOrder::create([
            ...$request->validated(),
            'total_price' => $menuItem->price * $request->quantity,
        ]);

        $order->load('menuItem');

        return response()->json([
            'message' => 'Your order has been placed successfully!',
            'data' => new MenuOrderResource($order),
        ], 201);
    }
}
