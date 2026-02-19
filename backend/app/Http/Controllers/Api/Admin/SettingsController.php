<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = SystemSetting::all()->keyBy('key');

        return response()->json(['settings' => $settings]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required',
        ]);

        foreach ($request->settings as $item) {
            SystemSetting::set($item['key'], $item['value']);
        }

        return response()->json(['message' => 'Pengaturan berhasil disimpan']);
    }

    public function adminUsers(): JsonResponse
    {
        $admins = User::whereIn('role', ['super_admin', 'admin_verifikasi', 'admin_produksi', 'admin_keuangan'])
            ->get(['id', 'name', 'email', 'role', 'is_active', 'last_login_at']);

        return response()->json(['admins' => $admins]);
    }

    public function createAdmin(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'admin_verifikasi', 'admin_produksi', 'admin_keuangan'])],
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'verification_status' => 'approved',
            'is_active' => true,
        ]);

        return response()->json(['message' => 'Admin berhasil dibuat', 'admin' => $admin], 201);
    }

    public function auditLogs(Request $request): JsonResponse
    {
        $logs = \App\Models\AuditLog::with('user')
            ->latest()
            ->paginate(50);

        return response()->json($logs);
    }
}
