<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('user', 'invoice.order')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => ['required', 'in:verified,rejected'],
            'notes'  => ['nullable', 'string', 'max:500'],
        ]);

        $payment->update([
            'status' => $request->action,
            'notes'  => $request->notes,
        ]);

        if ($request->action === 'verified') {
            $invoice = $payment->invoice;
            $totalPaid = $invoice->payments()->where('status', 'verified')->sum('amount');
            if ($totalPaid >= $invoice->amount) {
                $invoice->update(['status' => 'paid', 'paid_at' => now()]);
            }
        }

        $label = $request->action === 'verified' ? 'diverifikasi' : 'ditolak';
        return back()->with('success', "Pembayaran berhasil {$label}.");
    }
}
