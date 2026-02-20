<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $documents = $user->legalDocuments()->latest()->get();
        return view('verification.index', compact('user', 'documents'));
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'documents.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'doc_types.*' => ['required', 'string'],
        ]);

        $user = auth()->user();

        foreach ($request->file('documents', []) as $i => $file) {
            $path = $file->store('legal-documents/' . $user->id, 'public');
            LegalDocument::create([
                'user_id'       => $user->id,
                'type'          => $request->doc_types[$i] ?? 'other',
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
                'status'        => 'pending',
            ]);
        }

        $user->update([
            'legal_option'        => 'upload',
            'verification_status' => 'pending',
        ]);

        return redirect()->route('verification.index')
            ->with('success', 'Dokumen berhasil diupload. Kami akan memverifikasi dalam 1-3 hari kerja.');
    }

    public function buyPackage(Request $request)
    {
        $request->validate([
            'package_type' => ['required', 'in:pt_perorangan,pt_perseroan'],
        ]);

        $user = auth()->user();
        $user->update([
            'legal_option'        => 'buy_package',
            'legal_package_type'  => $request->package_type,
            'verification_status' => 'verified',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Paket legalitas berhasil dipilih. Akun Anda telah diaktifkan.');
    }
}
