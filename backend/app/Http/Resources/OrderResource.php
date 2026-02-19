<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),

            // Brand & Legal
            'brand_type' => $this->brand_type,
            'brand_name' => $this->brand_name,
            'brand_logo_url' => $this->brand_logo_url,
            'brand_description' => $this->brand_description,
            'include_bpom' => $this->include_bpom,
            'include_halal' => $this->include_halal,
            'include_haki_logo' => $this->include_haki_logo,
            'include_haki_djki' => $this->include_haki_djki,

            // Product
            'product_id' => $this->product_id,
            'volume_ml' => $this->volume_ml,
            'quantity' => $this->quantity,

            // Packaging
            'packaging_option_id' => $this->packaging_option_id,

            // Design
            'design_type' => $this->design_type,
            'design_file_url' => $this->design_file_url,
            'design_description' => $this->design_description,
            'design_price' => $this->design_price,

            // Sample
            'sample_requested' => $this->sample_requested,
            'sample_price' => $this->sample_price,
            'sample_status' => $this->sample_status,
            'sample_revisions_used' => $this->sample_revisions_used,

            // Pricing
            'subtotal_legal' => $this->subtotal_legal,
            'subtotal_product' => $this->subtotal_product,
            'ppn_rate' => $this->ppn_rate,
            'ppn_amount' => $this->ppn_amount,
            'grand_total' => $this->grand_total,
            'dp_amount' => $this->dp_amount,
            'remaining_amount' => $this->remaining_amount,

            // Shipping
            'shipping_tracking' => $this->shipping_tracking,
            'shipping_courier' => $this->shipping_courier,
            'shipped_at' => $this->shipped_at,
            'completed_at' => $this->completed_at,

            'admin_notes' => $this->admin_notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationships
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'product' => $this->whenLoaded('product'),
            'packaging_option' => $this->whenLoaded('packagingOption'),
            'order_materials' => $this->whenLoaded('orderMaterials'),
            'legal_items' => $this->whenLoaded('legalItems'),
            'invoices' => $this->whenLoaded('invoices'),
            'payments' => $this->whenLoaded('payments'),
            'mou' => $this->whenLoaded('mou'),
            'production_trackings' => $this->whenLoaded('productionTrackings'),
            'latest_tracking' => $this->whenLoaded('latestTracking'),
        ];
    }

    private function getStatusLabel(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Disubmit',
            'mou_pending' => 'MOU Pending Review',
            'mou_approved' => 'MOU Disetujui',
            'dp_pending' => 'Menunggu Pembayaran DP',
            'dp_confirmed' => 'DP Dikonfirmasi',
            'sample_process' => 'Proses Sample',
            'sample_approved' => 'Sample Disetujui',
            'production' => 'Proses Produksi',
            'qc' => 'Quality Control',
            'packing' => 'Packing & Labeling',
            'ready_to_ship' => 'Siap Kirim',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }
}
