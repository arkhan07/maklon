<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;

class NotificationService
{
    public function send(
        User $user,
        string $title,
        string $body,
        string $type = 'info',
        string $entityType = null,
        int $entityId = null,
        array $data = []
    ): AppNotification {
        return AppNotification::create([
            'user_id' => $user->id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'data' => $data,
        ]);
    }

    public function notifyAdmins(
        string $title,
        string $body,
        string $type = 'info',
        string $entityType = null,
        int $entityId = null
    ): void {
        $admins = User::whereIn('role', ['super_admin', 'admin_verifikasi', 'admin_produksi', 'admin_keuangan'])
            ->where('is_active', true)
            ->get();

        foreach ($admins as $admin) {
            $this->send($admin, $title, $body, $type, $entityType, $entityId);
        }
    }
}
