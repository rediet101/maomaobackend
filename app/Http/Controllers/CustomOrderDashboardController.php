<?php

namespace App\Http\Controllers;

use App\Models\CakeOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomOrderDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $orders = CakeOrder::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('custom-orders.index', compact('orders'));
    }

    public function show(CakeOrder $order): View
    {
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, CakeOrder $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
        ]);

        $status = $request->status;
        if ($status === 'confirmed') {
            $status = 'preparing';
        }

        $order->update(['status' => $status]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
