<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mou;
use App\Models\Order;
use App\Services\NotificationService;
use App\Services\PdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MouController extends Controller
{
    public function __construct(
        private PdfService $pdfService,
        private NotificationService $notificationService,
    ) {}

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $mou = $order->mou;

        if (!$mou) {
            return response()->json(['message' => 'MOU belum tersedia untuk order ini'], 404);
        }

        return response()->json(['mou' => $mou]);
    }

    public function download(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['user.profile', 'product', 'packagingOption', 'orderMaterials.material', 'legalItems']);

        return $this->pdfService->generateMou($order);
    }

    public function uploadSigned(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $request->validate([
            'signed_file_url' => 'required|string',
        ]);

        $mou = $order->mou;

        if (!$mou) {
            return response()->json(['message' => 'MOU belum digenerate'], 404);
        }

        if ($mou->status === 'approved') {
            return response()->json(['message' => 'MOU sudah diapprove'], 422);
        }

        $mou->update([
            'signed_file_url' => $request->signed_file_url,
            'status' => 'pending_review',
        ]);

        $order->update(['status' => 'mou_pending']);

        $this->notificationService->notifyAdmins(
            'MOU Pending Review',
            "Customer {$request->user()->name} mengupload MOU untuk order #{$order->order_number}",
            'warning',
            Order::class,
            $order->id
        );

        return response()->json(['message' => 'MOU berhasil diupload. Menunggu review admin.', 'mou' => $mou->fresh()]);
    }
}
