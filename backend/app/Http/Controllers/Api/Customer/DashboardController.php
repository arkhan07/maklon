<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->load(['profile', 'legalityDocument', 'legalityPackage']);

        $stats = [
            'total_orders' => $user->orders()->count(),
            'active_orders' => $user->orders()->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'pending_invoices' => $user->invoices()->where('status', 'pending')->count(),
            'total_spent' => $user->payments()->where('status', 'verified')->sum('amount'),
        ];

        $recent_orders = $user->orders()
            ->with(['product', 'latestTracking'])
            ->latest()
            ->take(5)
            ->get();

        $notifications = $user->appNotifications()
            ->latest()
            ->take(10)
            ->get();

        $unread_notifications = $user->appNotifications()->whereNull('read_at')->count();

        return response()->json([
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'notifications' => $notifications,
            'unread_notifications' => $unread_notifications,
            'verification_status' => $user->verification_status,
            'can_order' => $user->canOrder(),
        ]);
    }
}
