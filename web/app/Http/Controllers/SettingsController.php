<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        // Placeholder untuk pengaturan notifikasi, preferensi, dll
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
