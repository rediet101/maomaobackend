<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CakeOrder;
use App\Models\MenuOrder;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = collect();

        // New cake orders in the last 24 hours
        CakeOrder::where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->each(function (CakeOrder $order) use (&$notifications) {
                $notifications->push([
                    'id' => 'cake-new-'.$order->id,
                    'type' => 'new_order',
                    'category' => 'custom',
                    'title' => 'New Custom Order',
                    'body' => $order->name.' ordered a '.$order->flavour.' cake ('.$order->size.')',
                    'link' => route('orders.show', $order),
                    'time' => $order->created_at->toISOString(),
                    'time_human' => $order->created_at->diffForHumans(),
                    'avatar' => strtoupper(substr($order->name, 0, 1)),
                ]);
            });

        // New menu orders in the last 24 hours
        MenuOrder::with('menuItem')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->each(function (MenuOrder $order) use (&$notifications) {
                $notifications->push([
                    'id' => 'menu-new-'.$order->id,
                    'type' => 'new_order',
                    'category' => 'menu',
                    'title' => 'New Menu Order',
                    'body' => $order->name.' ordered '.($order->menuItem?->title ?? 'a cake').' ('.$order->size.')',
                    'link' => route('menu-orders.show', $order),
                    'time' => $order->created_at->toISOString(),
                    'time_human' => $order->created_at->diffForHumans(),
                    'avatar' => strtoupper(substr($order->name, 0, 1)),
                ]);
            });

        // Pickup date alerts — orders due in the next 3 days
        CakeOrder::whereBetween('pickup_delivery_date', [today(), today()->addDays(3)])
            ->get()
            ->each(function (CakeOrder $order) use (&$notifications) {
                $daysLeft = today()->diffInDays($order->pickup_delivery_date);
                $label = $daysLeft === 0 ? 'TODAY' : ($daysLeft === 1 ? 'tomorrow' : "in {$daysLeft} days");
                $notifications->push([
                    'id' => 'cake-due-'.$order->id,
                    'type' => 'pickup_alert',
                    'category' => 'custom',
                    'title' => '⚠️ Pickup Due '.$label,
                    'body' => $order->name."'s ".$order->flavour.' cake is due '.$label,
                    'link' => route('orders.show', $order),
                    'time' => $order->pickup_delivery_date->toDateTimeString(),
                    'time_human' => 'Due '.$label,
                    'avatar' => strtoupper(substr($order->name, 0, 1)),
                    'days_left' => $daysLeft,
                ]);
            });

        // Menu order pickup alerts
        MenuOrder::with('menuItem')
            ->whereBetween('pickup_delivery_date', [today(), today()->addDays(3)])
            ->get()
            ->each(function (MenuOrder $order) use (&$notifications) {
                $daysLeft = today()->diffInDays($order->pickup_delivery_date);
                $label = $daysLeft === 0 ? 'TODAY' : ($daysLeft === 1 ? 'tomorrow' : "in {$daysLeft} days");
                $notifications->push([
                    'id' => 'menu-due-'.$order->id,
                    'type' => 'pickup_alert',
                    'category' => 'menu',
                    'title' => '⚠️ Pickup Due '.$label,
                    'body' => $order->name."'s ".($order->menuItem?->title ?? 'cake').' is due '.$label,
                    'link' => route('menu-orders.show', $order),
                    'time' => $order->pickup_delivery_date->toDateTimeString(),
                    'time_human' => 'Due '.$label,
                    'avatar' => strtoupper(substr($order->name, 0, 1)),
                    'days_left' => $daysLeft,
                ]);
            });

        // Sort: alerts first, then newest
        $sorted = $notifications->sortBy([
            fn ($a, $b) => ($a['type'] === 'pickup_alert' ? 0 : 1) <=> ($b['type'] === 'pickup_alert' ? 0 : 1),
            fn ($a, $b) => ($a['days_left'] ?? 99) <=> ($b['days_left'] ?? 99),
        ])->values();

        return response()->json([
            'notifications' => $sorted,
            'unread_count' => $sorted->count(),
        ]);
    }
}
