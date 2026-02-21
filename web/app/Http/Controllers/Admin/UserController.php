<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->withCount('orders')->latest()->paginate(20);
        $stats = [
            'total'      => User::where('role', 'user')->count(),
            'verified'   => User::where('role', 'user')->where('verification_status', 'verified')->count(),
            'pending'    => User::where('role', 'user')->where('verification_status', 'pending')->count(),
            'unverified' => User::where('role', 'user')->where('verification_status', 'unverified')->count(),
        ];
        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        $user->load('orders.product', 'legalDocuments', 'invoices');
        return view('admin.users.show', compact('user'));
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'disuspend';
        return redirect()->back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }
}
