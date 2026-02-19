<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $order->load(['productionTrackings.updatedBy', 'latestTracking']);

        $timeline = [
            ['status' => 'submitted', 'label' => 'Order Dikonfirmasi', 'done' => true],
            ['status' => 'mou_approved', 'label' => 'MOU Disetujui', 'done' => in_array($order->status, ['mou_approved', 'dp_pending', 'dp_confirmed', 'sample_process', 'sample_approved', 'production', 'qc', 'packing', 'ready_to_ship', 'shipped', 'completed'])],
            ['status' => 'dp_confirmed', 'label' => 'DP Dikonfirmasi', 'done' => in_array($order->status, ['dp_confirmed', 'sample_process', 'sample_approved', 'production', 'qc', 'packing', 'ready_to_ship', 'shipped', 'completed'])],
            ['status' => 'production', 'label' => 'Proses Produksi', 'done' => in_array($order->status, ['production', 'qc', 'packing', 'ready_to_ship', 'shipped', 'completed'])],
            ['status' => 'qc', 'label' => 'Quality Control', 'done' => in_array($order->status, ['qc', 'packing', 'ready_to_ship', 'shipped', 'completed'])],
            ['status' => 'packing', 'label' => 'Packing & Labeling', 'done' => in_array($order->status, ['packing', 'ready_to_ship', 'shipped', 'completed'])],
            ['status' => 'shipped', 'label' => 'Dikirim', 'done' => in_array($order->status, ['shipped', 'completed'])],
            ['status' => 'completed', 'label' => 'Selesai', 'done' => $order->status === 'completed'],
        ];

        return response()->json([
            'order_number' => $order->order_number,
            'current_status' => $order->status,
            'timeline' => $timeline,
            'production_logs' => $order->productionTrackings,
            'shipping' => [
                'tracking_number' => $order->shipping_tracking,
                'courier' => $order->shipping_courier,
                'shipped_at' => $order->shipped_at,
            ],
        ]);
    }
}
