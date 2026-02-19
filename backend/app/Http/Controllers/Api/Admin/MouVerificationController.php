<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mou;
use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MouVerificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function pending(): JsonResponse
    {
        $mous = Mou::with(['order.user.profile', 'order.product'])
            ->where('status', 'pending_review')
            ->latest()
            ->paginate(20);

        return response()->json($mous);
    }

    public function show(Mou $mou): JsonResponse
    {
        $mou->load(['order.user.profile', 'order.product', 'order.legalItems', 'reviewer']);

        return response()->json(['mou' => $mou]);
    }

    public function approve(Request $request, Mou $mou): JsonResponse
    {
        $mou->update([
            'status' => 'approved',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $mou->order->update(['status' => 'mou_approved']);

        $this->notificationService->send(
            $mou->order->user,
            'MOU Disetujui',
            "MOU untuk order #{$mou->order->order_number} telah disetujui. Silakan lakukan pembayaran DP.",
            'success',
            Order::class,
            $mou->order_id
        );

        return response()->json(['message' => 'MOU berhasil diapprove', 'mou' => $mou->fresh()]);
    }

    public function reject(Request $request, Mou $mou): JsonResponse
    {
        $request->validate(['notes' => 'required|string']);

        $mou->update([
            'status' => 'rejected',
            'notes' => $request->notes,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $mou->order->update(['status' => 'submitted']);

        $this->notificationService->send(
            $mou->order->user,
            'MOU Ditolak',
            "MOU order #{$mou->order->order_number} ditolak. Alasan: {$request->notes}. Silakan upload ulang.",
            'error',
            Order::class,
            $mou->order_id
        );

        return response()->json(['message' => 'MOU ditolak', 'mou' => $mou->fresh()]);
    }

    public function history(): JsonResponse
    {
        $mous = Mou::with(['order.user', 'reviewer'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('reviewed_at')
            ->paginate(20);

        return response()->json($mous);
    }
}
