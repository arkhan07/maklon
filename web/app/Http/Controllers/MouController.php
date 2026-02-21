<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MouDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MouController extends Controller
{
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $mou = $order->mouDocument;
        return view('orders.mou', compact('order', 'mou'));
    }

    public function download(Order $order)
    {
        $this->authorize('view', $order);
        $mou = $order->mouDocument;
        if (!$mou || !$mou->generated_pdf) {
            return back()->with('error', 'MOU belum tersedia.');
        }
        return Storage::disk('public')->download($mou->generated_pdf);
    }

    public function uploadSigned(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $request->validate([
            'signed_mou' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $mou = $order->mouDocument ?? MouDocument::create([
            'order_id' => $order->id,
            'status'   => 'waiting_signature',
        ]);

        $path = $request->file('signed_mou')->store('mou-signed/' . $order->id, 'public');
        $mou->update([
            'signed_pdf' => $path,
            'status'     => 'signed_uploaded',
        ]);
        $order->update(['mou_status' => 'signed']);

        return redirect()->route('mou.show', $order)
            ->with('success', 'MOU berhasil diupload. Admin akan memverifikasi segera.');
    }
}
