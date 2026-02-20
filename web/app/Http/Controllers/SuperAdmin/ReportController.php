<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $monthlyRevenue = Payment::where('status', 'verified')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $stats = [
            'total_revenue'  => Payment::where('status', 'verified')->sum('amount'),
            'this_month'     => Payment::where('status', 'verified')->whereMonth('created_at', now()->month)->sum('amount'),
            'total_orders'   => Order::count(),
            'total_customers'=> User::where('role', 'user')->count(),
        ];

        return view('super_admin.reports.index', compact('stats', 'monthlyRevenue'));
    }
}
