<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MouDocument;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'       => Order::count(),
            'orders_pending'     => Order::where('status', 'pending')->count(),
            'orders_in_progress' => Order::where('status', 'in_progress')->count(),
            'orders_completed'   => Order::where('status', 'completed')->count(),
            'users_pending'      => User::where('verification_status', 'pending')->count(),
            'users_verified'     => User::where('verification_status', 'verified')->count(),
            'mou_pending'        => MouDocument::where('status', 'signed_uploaded')->count(),
            'payments_pending'   => Payment::where('status', 'pending')->count(),
            'revenue_this_month' => Payment::where('status', 'verified')->whereMonth('created_at', now()->month)->sum('amount'),
        ];

        $recentOrders = Order::with('user', 'product')->latest()->limit(10)->get();
        $pendingUsers = User::where('verification_status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingUsers'));
    }
}
