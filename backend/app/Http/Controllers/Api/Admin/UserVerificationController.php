<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\LegalityDocument;
use App\Models\LegalityPackage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function pending(Request $request): JsonResponse
    {
        $users = User::with(['legalityDocument', 'legalityPackage', 'profile'])
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(20);

        return response()->json($users);
    }

    public function show(User $user): JsonResponse
    {
        $user->load(['legalityDocument', 'legalityPackage', 'profile', 'orders']);

        return response()->json(['user' => new UserResource($user)]);
    }

    public function approve(Request $request, User $user): JsonResponse
    {
        $user->update([
            'verification_status' => 'approved',
            'verification_notes' => null,
        ]);

        // Approve the document if exists
        if ($user->legalityDocument) {
            $user->legalityDocument->update([
                'status' => 'approved',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ]);
        }

        // Activate package if bought
        if ($user->legalityPackage && !$user->legalityPackage->activated_at) {
            $user->legalityPackage->update([
                'payment_status' => 'verified',
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'activated_at' => now(),
            ]);
        }

        $this->notificationService->send(
            $user,
            'Verifikasi Legalitas Disetujui',
            'Dokumen legalitas Anda telah diverifikasi. Anda sekarang dapat melakukan order!',
            'success'
        );

        return response()->json(['message' => 'User berhasil diverifikasi', 'user' => new UserResource($user->fresh())]);
    }

    public function reject(Request $request, User $user): JsonResponse
    {
        $request->validate(['notes' => 'required|string']);

        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->notes,
        ]);

        if ($user->legalityDocument) {
            $user->legalityDocument->update([
                'status' => 'rejected',
                'notes' => $request->notes,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ]);
        }

        $this->notificationService->send(
            $user,
            'Verifikasi Legalitas Ditolak',
            "Dokumen Anda ditolak. Alasan: {$request->notes}. Silakan upload ulang.",
            'error'
        );

        return response()->json(['message' => 'Verifikasi ditolak', 'user' => new UserResource($user->fresh())]);
    }

    public function history(Request $request): JsonResponse
    {
        $docs = LegalityDocument::with(['user.profile', 'reviewer'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('reviewed_at')
            ->paginate(20);

        return response()->json($docs);
    }

    public function allUsers(Request $request): JsonResponse
    {
        $users = User::with(['profile', 'legalityDocument'])
            ->where('role', 'customer')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->verification_status, fn($q) => $q->where('verification_status', $request->verification_status))
            ->latest()
            ->paginate(20);

        return response()->json($users);
    }

    public function toggleActive(User $user): JsonResponse
    {
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'message' => $user->is_active ? 'Akun diaktifkan' : 'Akun dinonaktifkan',
            'user' => new UserResource($user),
        ]);
    }
}
