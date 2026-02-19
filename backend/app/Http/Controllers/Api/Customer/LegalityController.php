<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\LegalityDocument;
use App\Models\LegalityPackage;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LegalityController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function status(Request $request): JsonResponse
    {
        $user = $request->user()->load(['legalityDocument', 'legalityPackage']);

        return response()->json([
            'verification_status' => $user->verification_status,
            'verification_notes' => $user->verification_notes,
            'document' => $user->legalityDocument,
            'package' => $user->legalityPackage,
        ]);
    }

    // Option A: Upload documents
    public function uploadDocument(Request $request): JsonResponse
    {
        $request->validate([
            'akta_url' => 'required|string',
            'nib_url' => 'required|string',
            'siup_url' => 'nullable|string',
        ]);

        $user = $request->user();

        $doc = LegalityDocument::updateOrCreate(
            ['user_id' => $user->id],
            [
                'akta_url' => $request->akta_url,
                'nib_url' => $request->nib_url,
                'siup_url' => $request->siup_url,
                'status' => 'pending',
                'notes' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]
        );

        $user->update(['verification_status' => 'pending']);

        $this->notificationService->notifyAdmins(
            'Dokumen Legalitas Baru',
            "{$user->name} mengupload dokumen legalitas. Perlu direview.",
            'warning'
        );

        return response()->json([
            'message' => 'Dokumen berhasil diupload. Menunggu review admin (1-3 hari kerja).',
            'document' => $doc,
        ]);
    }

    // Option B: Buy legality package
    public function buyPackage(Request $request): JsonResponse
    {
        $request->validate([
            'package_type' => ['required', Rule::in(['pt_perorangan', 'pt_perseroan'])],
            'payment_proof_url' => 'required|string',
        ]);

        $user = $request->user();

        $prices = ['pt_perorangan' => 1500000, 'pt_perseroan' => 5000000];
        $price = $prices[$request->package_type];

        $package = LegalityPackage::updateOrCreate(
            ['user_id' => $user->id],
            [
                'package_type' => $request->package_type,
                'price' => $price,
                'payment_status' => 'paid',
                'payment_proof_url' => $request->payment_proof_url,
            ]
        );

        $user->update(['verification_status' => 'pending']);

        $this->notificationService->notifyAdmins(
            'Pembelian Paket Legalitas',
            "{$user->name} membeli paket legalitas {$request->package_type}. Perlu konfirmasi pembayaran.",
            'warning'
        );

        return response()->json([
            'message' => 'Pembelian paket berhasil. Menunggu konfirmasi admin.',
            'package' => $package,
        ], 201);
    }
}
