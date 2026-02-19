<?php

namespace App\Services;

use App\Models\Mou;
use App\Models\Order;

class MouService
{
    public function generate(Order $order): Mou
    {
        // In production, generate a real PDF and store URL
        // For now, create the MOU record with a placeholder URL
        $mou = Mou::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'generated_file_url' => "/api/orders/{$order->id}/mou/download",
                'status' => 'pending_upload',
            ]
        );

        return $mou;
    }
}
