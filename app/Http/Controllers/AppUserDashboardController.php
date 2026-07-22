<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\View\View;

class AppUserDashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $search = $request->input('search');

        $users = AppUser::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest('last_seen_at')
            ->paginate(15)
            ->appends($request->query());

        return view('app-users.index', compact('users'));
    }
}
