<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'type' => $this->type,
            'type_label' => match ($this->type) {
                'dp' => 'Down Payment (50%)',
                'pelunasan' => 'Pelunasan (50%)',
                'legalitas' => 'Biaya Legalitas',
                'sample' => 'Biaya Sample',
                'full' => 'Pembayaran Penuh',
                default => $this->type,
            },
            'status' => $this->status,
            'subtotal_legal' => $this->subtotal_legal,
            'subtotal_product' => $this->subtotal_product,
            'subtotal_sample' => $this->subtotal_sample,
            'ppn_amount' => $this->ppn_amount,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'paid_at' => $this->paid_at,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'order' => $this->whenLoaded('order', fn() => new OrderResource($this->order)),
            'payments' => $this->whenLoaded('payments'),
        ];
    }
}
