<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function invoices(Request $request): JsonResponse
    {
        $invoices = Invoice::with(['user.profile', 'order.product'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->search, fn($q) => $q->where('invoice_number', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return response()->json($invoices);
    }

    public function payments(Request $request): JsonResponse
    {
        $payments = Payment::with(['user.profile', 'invoice', 'order.product', 'verifier'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return response()->json($payments);
    }

    public function summary(Request $request): JsonResponse
    {
        $period = $request->period ?? 'monthly';
        $now = now();

        $query = Payment::where('status', 'verified');

        if ($period === 'monthly') {
            $query->whereMonth('verified_at', $now->month)->whereYear('verified_at', $now->year);
        } elseif ($period === 'yearly') {
            $query->whereYear('verified_at', $now->year);
        }

        $summary = [
            'total_revenue' => $query->sum('amount'),
            'total_paid_invoices' => Invoice::where('status', 'paid')->count(),
            'total_pending_invoices' => Invoice::where('status', 'pending')->count(),
            'outstanding_amount' => Invoice::where('status', 'pending')->sum('amount'),
            'monthly_breakdown' => Payment::where('status', 'verified')
                ->whereYear('verified_at', $now->year)
                ->selectRaw('MONTH(verified_at) as month, SUM(amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];

        return response()->json($summary);
    }
}
