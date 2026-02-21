<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'   => User::where('role', 'user')->count(),
            'total_admins'  => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'total_orders'  => Order::count(),
            'total_revenue' => Payment::where('status', 'verified')->sum('amount'),
        ];
        $admins = User::whereIn('role', ['admin', 'super_admin'])->latest()->get();
        return view('super_admin.dashboard', compact('stats', 'admins'));
    }
}
