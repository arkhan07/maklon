<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'business_type' => $this->business_type,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'is_active' => $this->is_active,
            'verification_status' => $this->verification_status,
            'verification_notes' => $this->verification_notes,
            'can_order' => $this->canOrder(),
            'is_admin' => $this->isAdmin(),
            'last_login_at' => $this->last_login_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'profile' => $this->whenLoaded('profile'),
            'legality_document' => $this->whenLoaded('legalityDocument'),
            'legality_package' => $this->whenLoaded('legalityPackage'),
        ];
    }
}
