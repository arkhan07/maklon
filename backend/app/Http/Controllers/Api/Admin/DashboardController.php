<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $month = now()->startOfMonth();

        $stats = [
            'total_active_orders' => Order::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'monthly_revenue' => Payment::where('status', 'verified')->where('created_at', '>=', $month)->sum('amount'),
            'pending_verifications' => User::where('verification_status', 'pending')->count(),
            'pending_mou' => \App\Models\Mou::where('status', 'pending_review')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'overdue_orders' => Order::where('status', 'dp_confirmed')
                ->where('created_at', '<', now()->subDays(30))
                ->count(),
            'total_users' => User::where('role', 'customer')->count(),
            'total_completed_orders' => Order::where('status', 'completed')->count(),
        ];

        $recent_orders = Order::with(['user', 'product', 'latestTracking'])
            ->latest()
            ->take(10)
            ->get();

        $pending_verifications = User::with('legalityDocument')
            ->where('verification_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $pending_payments = Payment::with(['user', 'invoice.order'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'pending_verifications' => $pending_verifications,
            'pending_payments' => $pending_payments,
        ]);
    }
}
