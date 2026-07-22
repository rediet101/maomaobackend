<?php

namespace App\Http\Controllers;

use App\Models\CakeOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
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
