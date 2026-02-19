<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('user', 'order')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(15)->withQueryString();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order', 'user', 'payments');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => ['required', 'in:pending,paid,overdue'],
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'paid' && !$invoice->paid_at) {
            $data['paid_at'] = now();
        }

        $invoice->update($data);
        return back()->with('success', "Status invoice #{$invoice->invoice_number} diperbarui.");
    }
}
