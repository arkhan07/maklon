<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index(Request $request): JsonResponse
    {
        $payments = $request->user()
            ->payments()
            ->with(['invoice', 'order.product'])
            ->latest()
            ->paginate(15);

        return response()->json($payments);
    }

    public function uploadProof(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);

        if ($invoice->status === 'paid') {
            return response()->json(['message' => 'Invoice ini sudah lunas'], 422);
        }

        // For DP payment: MOU must be approved
        if ($invoice->type === 'dp') {
            $mou = $invoice->order->mou;
            if (!$mou || $mou->status !== 'approved') {
                return response()->json(['message' => 'MOU belum diapprove. Silakan upload MOU yang sudah ditandatangani terlebih dahulu.'], 422);
            }
        }

        $request->validate([
            'payment_proof_url' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $payment = Payment::create([
            'payment_number' => Payment::generatePaymentNumber(),
            'invoice_id' => $invoice->id,
            'order_id' => $invoice->order_id,
            'user_id' => $request->user()->id,
            'type' => $invoice->type,
            'amount' => $request->amount,
            'payment_proof_url' => $request->payment_proof_url,
            'status' => 'pending',
        ]);

        // Notify admins
        $this->notificationService->notifyAdmins(
            'Bukti Pembayaran Baru',
            "Customer {$request->user()->name} mengupload bukti pembayaran untuk order #{$invoice->order->order_number}",
            'warning'
        );

        return response()->json([
            'message' => 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.',
            'payment' => new PaymentResource($payment),
        ], 201);
    }
}
