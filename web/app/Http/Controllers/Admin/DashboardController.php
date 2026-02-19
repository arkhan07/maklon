<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_orders'   => Order::count(),
            'active_orders'  => Order::whereNotIn('status', ['done', 'cancelled'])->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'revenue'        => Invoice::where('status', 'paid')->sum('amount'),
        ];

        $recentOrders = Order::with('user')->latest()->limit(5)->get();
        $pendingPayments = Payment::with('invoice.order', 'user')->where('status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingPayments'));
    }
}
