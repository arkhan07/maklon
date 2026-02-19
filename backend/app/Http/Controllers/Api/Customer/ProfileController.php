<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()->load(['profile', 'legalityDocument', 'legalityPackage'])),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'business_type' => 'sometimes|string|max:100',
            'company_name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'npwp' => 'sometimes|string|max:30',
            'bank_name' => 'sometimes|string|max:100',
            'bank_account' => 'sometimes|string|max:50',
            'bank_holder' => 'sometimes|string|max:255',
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'phone', 'business_type']));

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['company_name', 'address', 'npwp', 'bank_name', 'bank_account', 'bank_holder'])
        );

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => new UserResource($user->fresh()->load('profile')),
        ]);
    }

    public function notifications(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->appNotifications()
            ->latest()
            ->paginate(20);

        return response()->json($notifications);
    }

    public function markNotificationRead(Request $request, int $id): JsonResponse
    {
        $notification = $request->user()->appNotifications()->findOrFail($id);
        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notifikasi ditandai sudah dibaca']);
    }

    public function markAllNotificationsRead(Request $request): JsonResponse
    {
        $request->user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['message' => 'Semua notifikasi ditandai sudah dibaca']);
    }
}
