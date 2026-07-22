<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCakeOrderRequest;
use App\Models\CakeOrder;
use App\Http\Resources\CakeOrderResource;
use App\Http\Resources\MenuOrderResource;
use App\Models\MenuOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CakeOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $phone = $request->query('phone');

        $cakeQuery = CakeOrder::latest();
        $menuQuery = MenuOrder::with('menuItem')->latest();

        if ($phone) {
            $cleanPhone = preg_replace('/\D/', '', $phone);
            $last9 = substr($cleanPhone, -9);

            if (strlen($last9) === 9) {
                $cakeQuery->where('phone', 'like', '%' . $last9);
                $menuQuery->where('phone', 'like', '%' . $last9);
            } else {
                $cakeQuery->where('phone', $phone);
                $menuQuery->where('phone', $phone);
            }
        }

        $cakeOrders = $cakeQuery->get();
        $menuOrders = $menuQuery->get();

        // Transform collections using their resources
        $cakeResources = CakeOrderResource::collection($cakeOrders)->resolve();
        $menuResources = MenuOrderResource::collection($menuOrders)->resolve();

        // Add a type identifier for clarity
        foreach ($cakeResources as &$item) {
            $item['order_type'] = 'custom';
        }
        foreach ($menuResources as &$item) {
            $item['order_type'] = 'menu';
        }

        // Merge and sort by created_at descending
        $merged = collect($cakeResources)
            ->merge($menuResources)
            ->sortByDesc('created_at')
            ->values()
            ->all();

        return response()->json(['data' => $merged]);
    }

    public function store(StoreCakeOrderRequest $request): JsonResponse
    {
        $order = CakeOrder::create($request->validated());

        return response()->json([
            'message' => 'Your order has been submitted successfully!',
            'data' => $order,
        ], 201);
    }

    public function completeOrder(Request $request, int $id): JsonResponse
    {
        $type = $request->input('order_type', 'custom');

        if ($type === 'menu') {
            $order = MenuOrder::find($id);
            if (! $order) {
                $order = CakeOrder::findOrFail($id);
            }
        } else {
            $order = CakeOrder::find($id);
            if (! $order) {
                $order = MenuOrder::findOrFail($id);
            }
        }

        $order->update(['status' => 'completed']);

        return response()->json([
            'message' => 'Order marked as completed.',
            'status' => 'completed',
        ]);
    }

    public function submitFeedback(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'order_type' => 'nullable|string',
        ]);

        $type = $request->input('order_type', 'custom');

        if ($type === 'menu') {
            $order = MenuOrder::find($id);
            if (! $order) {
                $order = CakeOrder::findOrFail($id);
            }
        } else {
            $order = CakeOrder::find($id);
            if (! $order) {
                $order = CakeOrder::find($id) ?? MenuOrder::findOrFail($id);
            }
        }

        $order->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'status' => 'completed',
        ]);

        return response()->json([
            'message' => 'Thank you for your feedback!',
            'rating' => (int) $order->rating,
            'feedback' => $order->feedback,
            'status' => 'completed',
        ]);
    }
}
