<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\ProductionTracking;
use App\Services\InvoiceService;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderManagementController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService,
        private NotificationService $notificationService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = Order::with(['user.profile', 'product', 'latestTracking'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('order_number', 'like', "%{$request->search}%"))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->latest()
            ->paginate(20);

        return response()->json($orders);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load([
            'user.profile',
            'product.category',
            'packagingOption.packagingType',
            'orderMaterials.material',
            'legalItems',
            'invoices',
            'payments.verifier',
            'mou.reviewer',
            'productionTrackings.updatedBy',
        ]);

        return response()->json(['order' => new OrderResource($order)]);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in([
                'submitted', 'mou_pending', 'mou_approved', 'dp_pending', 'dp_confirmed',
                'sample_process', 'sample_approved', 'production', 'qc',
                'packing', 'ready_to_ship', 'shipped', 'completed', 'cancelled',
            ])],
            'notes' => 'nullable|string',
        ]);

        $order->update([
            'status' => $request->status,
            'admin_notes' => $request->notes ?? $order->admin_notes,
        ]);

        // Log production tracking for production-related statuses
        $productionStatuses = ['production', 'qc', 'packing', 'ready_to_ship', 'shipped', 'completed'];
        if (in_array($request->status, $productionStatuses)) {
            ProductionTracking::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'notes' => $request->notes,
                'updated_by' => $request->user()->id,
            ]);
        }

        // Update completed_at
        if ($request->status === 'completed') {
            $order->update(['completed_at' => now()]);
        }

        // Create pelunasan invoice when production starts
        if ($request->status === 'production') {
            $this->invoiceService->createPelunasanInvoice($order);
        }

        $this->notificationService->send(
            $order->user,
            'Status Order Diperbarui',
            "Order #{$order->order_number} status: " . ucfirst(str_replace('_', ' ', $request->status)),
            'info',
            Order::class,
            $order->id
        );

        return response()->json(['message' => 'Status order berhasil diperbarui', 'order' => new OrderResource($order->fresh())]);
    }

    public function updateShipping(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'shipping_tracking' => 'required|string',
            'shipping_courier' => 'required|string',
        ]);

        $order->update([
            'shipping_tracking' => $request->shipping_tracking,
            'shipping_courier' => $request->shipping_courier,
            'shipped_at' => now(),
            'status' => 'shipped',
        ]);

        ProductionTracking::create([
            'order_id' => $order->id,
            'status' => 'shipped',
            'notes' => "Dikirim via {$request->shipping_courier}, resi: {$request->shipping_tracking}",
            'updated_by' => $request->user()->id,
        ]);

        $this->notificationService->send(
            $order->user,
            'Produk Dikirim!',
            "Order #{$order->order_number} telah dikirim via {$request->shipping_courier}. No. Resi: {$request->shipping_tracking}",
            'success',
            Order::class,
            $order->id
        );

        return response()->json(['message' => 'Info pengiriman berhasil disimpan', 'order' => new OrderResource($order->fresh())]);
    }

    public function confirmPayment(Request $request, \App\Models\Payment $payment): JsonResponse
    {
        $request->validate([
            'action' => ['required', Rule::in(['approve', 'reject'])],
            'notes' => 'nullable|string',
        ]);

        if ($request->action === 'approve') {
            $payment->update([
                'status' => 'verified',
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'notes' => $request->notes,
            ]);

            $payment->invoice->update(['status' => 'paid', 'paid_at' => now()]);

            // Update order status
            $order = $payment->order;
            if ($payment->type === 'dp') {
                $order->update(['status' => 'dp_confirmed']);
            } elseif ($payment->type === 'pelunasan') {
                $order->update(['status' => 'completed', 'completed_at' => now()]);
            }

            $message = "Pembayaran untuk order #{$order->order_number} telah dikonfirmasi.";
            $this->notificationService->send($order->user, 'Pembayaran Dikonfirmasi', $message, 'success', Order::class, $order->id);
        } else {
            $payment->update([
                'status' => 'rejected',
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'notes' => $request->notes,
            ]);

            $message = "Bukti pembayaran order #{$payment->order->order_number} ditolak. {$request->notes}";
            $this->notificationService->send($payment->user, 'Pembayaran Ditolak', $message, 'error');
        }

        return response()->json(['message' => 'Pembayaran ' . ($request->action === 'approve' ? 'dikonfirmasi' : 'ditolak')]);
    }

    public function pendingPayments(): JsonResponse
    {
        $payments = \App\Models\Payment::with(['user.profile', 'invoice', 'order.product'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return response()->json($payments);
    }
}
