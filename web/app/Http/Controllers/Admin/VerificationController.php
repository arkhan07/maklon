<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('verification_status', 'pending')
            ->with('legalDocuments')->latest()->paginate(15);
        $stats = [
            'pending'  => User::where('verification_status', 'pending')->count(),
            'verified' => User::where('verification_status', 'verified')->count(),
            'rejected' => User::where('verification_status', 'rejected')->count(),
        ];
        return view('admin.verifikasi.index', compact('pendingUsers', 'stats'));
    }

    public function show(User $user)
    {
        $user->load('legalDocuments');
        return view('admin.verifikasi.show', compact('user'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update([
            'verification_status' => 'verified',
            'verification_notes'  => $request->notes,
            'verified_at'         => now(),
        ]);
        $user->legalDocuments()->where('status', 'pending')->update(['status' => 'approved', 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);

        return redirect()->route('admin.verifikasi.index')
            ->with('success', "Akun {$user->name} berhasil diverifikasi.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate(['notes' => ['required', 'string']]);
        $user->update([
            'verification_status' => 'rejected',
            'verification_notes'  => $request->notes,
        ]);
        $user->legalDocuments()->where('status', 'pending')->update(['status' => 'rejected', 'notes' => $request->notes, 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);

        return redirect()->route('admin.verifikasi.index')
            ->with('success', "Verifikasi {$user->name} ditolak. Catatan telah dikirim.");
    }
}
