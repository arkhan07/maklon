<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $stats = [
            'total_orders'    => $user->orders()->count(),
            'active_orders'   => $user->orders()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count(),
            'completed_orders'=> $user->orders()->where('status', 'completed')->count(),
            'pending_invoices'=> $user->invoices()->where('status', 'pending')->sum('amount'),
        ];

        $recentOrders = $user->orders()->with('product')->latest()->limit(5)->get();

        return view('dashboard', compact('user', 'stats', 'recentOrders'));
    }
}
