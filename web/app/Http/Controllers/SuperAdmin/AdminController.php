<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->latest()->paginate(20);
        return view('super_admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'role'     => ['required', 'in:admin,super_admin'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        User::create([
            'name'                => $request->name,
            'email'               => $request->email,
            'role'                => $request->role,
            'password'            => Hash::make($request->password),
            'verification_status' => 'verified',
            'is_active'           => true,
        ]);
        return redirect()->route('super_admin.admins.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate(['role' => ['required', 'in:admin,super_admin']]);
        $user->update(['role' => $request->role]);
        return redirect()->route('super_admin.admins.index')->with('success', 'Role admin berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('super_admin.admins.index')->with('success', 'Admin berhasil dihapus.');
    }
}
