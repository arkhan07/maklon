<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\PackagingOption;
use App\Models\Product;

class InvoiceService
{
    public function calculateOrderPricing(Order $order): void
    {
        $qty = $order->quantity ?? 1;
        $volumeMl = $order->volume_ml ?? 1;

        // Base formula cost
        $product = Product::find($order->product_id);
        $baseCost = $product ? $product->base_price_per_100ml * ($volumeMl / 100) * $qty : 0;

        // Material add-on cost
        $materialCost = $order->orderMaterials->sum(fn($om) => $om->price_per_ml * $om->dose_ml * $qty);

        // Packaging cost
        $packagingCost = 0;
        if ($order->packaging_option_id) {
            $packaging = PackagingOption::find($order->packaging_option_id);
            $packagingCost = $packaging ? $packaging->price * $qty : 0;
        }

        // Design cost
        $designCost = $order->design_type === 'jasa_design' ? 750000 : 0;

        // Sample cost
        $sampleCost = $order->sample_requested ? 500000 : 0;

        // Legal cost
        $legalCost = 0;
        if ($order->include_bpom) $legalCost += 1250000;
        if ($order->include_halal) $legalCost += 2500000;
        if ($order->include_haki_logo) $legalCost += 1500000;
        if ($order->include_haki_djki) $legalCost += 2750000;

        // Subtotals
        $subtotalProduct = $baseCost + $materialCost + $packagingCost + $designCost;
        $ppnRate = 11;
        $ppnAmount = ($subtotalProduct + $legalCost + $sampleCost) * ($ppnRate / 100);
        $grandTotal = $subtotalProduct + $legalCost + $sampleCost + $ppnAmount;
        $dpAmount = $legalCost + $sampleCost + ($subtotalProduct * 0.5) + $ppnAmount;
        $remainingAmount = $subtotalProduct * 0.5;

        $order->update([
            'subtotal_legal' => round($legalCost),
            'subtotal_product' => round($subtotalProduct),
            'ppn_rate' => $ppnRate,
            'ppn_amount' => round($ppnAmount),
            'grand_total' => round($grandTotal),
            'dp_amount' => round($dpAmount),
            'remaining_amount' => round($remainingAmount),
            'design_price' => $designCost,
            'sample_price' => $sampleCost,
        ]);
    }

    public function createDpInvoice(Order $order): Invoice
    {
        return Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => 'dp',
            'status' => 'pending',
            'subtotal_legal' => $order->subtotal_legal,
            'subtotal_product' => round($order->subtotal_product * 0.5),
            'subtotal_sample' => $order->sample_price,
            'ppn_amount' => $order->ppn_amount,
            'amount' => $order->dp_amount,
            'due_date' => now()->addDays(7),
        ]);
    }

    public function createPelunasanInvoice(Order $order): Invoice
    {
        // Check if pelunasan invoice already exists
        $existing = Invoice::where('order_id', $order->id)->where('type', 'pelunasan')->first();
        if ($existing) return $existing;

        return Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => 'pelunasan',
            'status' => 'pending',
            'subtotal_legal' => 0,
            'subtotal_product' => $order->remaining_amount,
            'subtotal_sample' => 0,
            'ppn_amount' => 0,
            'amount' => $order->remaining_amount,
            'due_date' => now()->addDays(14),
            'notes' => 'Pelunasan 50% - Dibayar setelah produk jadi & siap kirim',
        ]);
    }
}
