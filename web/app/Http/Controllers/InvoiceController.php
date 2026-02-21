<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoices()->with('order')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load('order', 'payments');
        return view('invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
        $invoice->load('order.product', 'payments', 'user');
        return view('invoices.print', compact('invoice'));
    }
}
