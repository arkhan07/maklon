<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments()->with('invoice.order')->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
        if ($invoice->status === 'paid') {
            return redirect()->route('invoices.show', $invoice)
                ->with('info', 'Invoice ini sudah lunas.');
        }
        return view('payments.create', compact('invoice'));
    }

    public function store(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['required', 'in:transfer,qris,virtual_account'],
            'proof'  => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'notes'  => ['nullable', 'string', 'max:500'],
        ], [
            'proof.required' => 'Bukti pembayaran wajib diunggah.',
            'proof.mimes'    => 'Bukti harus berformat JPG, PNG, atau PDF.',
            'proof.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $proofPath = $request->file('proof')->store('payment_proofs', 'public');

        Payment::create([
            'invoice_id' => $invoice->id,
            'user_id'    => auth()->id(),
            'amount'     => $request->amount,
            'method'     => $request->method,
            'proof_file' => $proofPath,
            'status'     => 'pending',
            'notes'      => $request->notes,
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
