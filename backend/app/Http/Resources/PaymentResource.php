<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'payment_number' => $this->payment_number,
            'type' => $this->type,
            'amount' => $this->amount,
            'payment_proof_url' => $this->payment_proof_url,
            'status' => $this->status,
            'notes' => $this->notes,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
            'invoice' => $this->whenLoaded('invoice', fn() => new InvoiceResource($this->invoice)),
            'verifier' => $this->whenLoaded('verifier'),
        ];
    }
}
