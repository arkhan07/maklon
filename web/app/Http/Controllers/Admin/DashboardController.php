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
            'total_users'      => User::count(),
            'total_orders'     => Order::count(),
            'active_orders'    => Order::whereIn('status', ['pending', 'confirmed', 'in_progress'])->count(),
            'orders_pending'   => Order::where('status', 'pending')->count(),
            'orders_completed' => Order::where('status', 'completed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'mou_pending'      => MouDocument::where('status', 'signed_uploaded')->count(),
            'revenue'          => Payment::where('status', 'verified')->whereMonth('created_at', now()->month)->sum('amount'),
        ];

        $recentOrders    = Order::with('user', 'product')->latest()->limit(10)->get();
        $pendingPayments = Payment::with('user')->where('status', 'pending')->latest()->limit(5)->get();
        $pendingUsers    = User::where('verification_status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingPayments', 'pendingUsers'));
    }
}
