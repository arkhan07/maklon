<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MouDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MouController extends Controller
{
    public function index()
    {
        $mous = MouDocument::with('order.user')->latest()->paginate(20);
        $stats = [
            'pending'  => MouDocument::where('status', 'signed_uploaded')->count(),
            'approved' => MouDocument::where('status', 'approved')->count(),
            'rejected' => MouDocument::where('status', 'rejected')->count(),
        ];
        return view('admin.mou.index', compact('mous', 'stats'));
    }

    public function show(MouDocument $mou)
    {
        $mou->load('order.user');
        return view('admin.mou.show', compact('mou'));
    }

    public function approve(Request $request, MouDocument $mou)
    {
        $mou->update([
            'status'      => 'approved',
            'notes'       => $request->notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $mou->order->update(['mou_status' => 'approved']);

        return redirect()->route('admin.mou.index')
            ->with('success', 'MOU berhasil diapprove. Customer dapat melakukan pembayaran DP.');
    }

    public function reject(Request $request, MouDocument $mou)
    {
        $request->validate(['notes' => ['required', 'string']]);
        $mou->update([
            'status'      => 'rejected',
            'notes'       => $request->notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $mou->order->update(['mou_status' => 'waiting']);

        return redirect()->route('admin.mou.index')
            ->with('success', 'MOU ditolak. Customer perlu upload ulang.');
    }
}
