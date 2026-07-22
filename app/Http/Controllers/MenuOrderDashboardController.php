<?php

namespace App\Http\Controllers;

use App\Models\MenuOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuOrderDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $orders = MenuOrder::with('menuItem')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('menu-orders.index', compact('orders'));
    }

    public function show(MenuOrder $menuOrder): View
    {
        $menuOrder->load('menuItem');

        return view('menu-orders.show', compact('menuOrder'));
    }

    public function updateStatus(Request $request, MenuOrder $menuOrder): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
        ]);

        $status = $request->status;
        if ($status === 'confirmed') {
            $status = 'preparing';
        }

        $orderStatus = $menuOrder->update(['status' => $status]);

        return back()->with('success', 'Menu order status updated successfully.');
    }
}
