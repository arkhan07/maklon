<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\MouDocument;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'product')->latest()->paginate(20);
        $stats = [
            'pending'     => Order::where('status', 'pending')->count(),
            'in_progress' => Order::where('status', 'in_progress')->count(),
            'completed'   => Order::where('status', 'completed')->count(),
        ];
        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'product', 'packagingType', 'mouDocument', 'invoices', 'payments');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => ['required', 'in:pending,confirmed,in_progress,completed,cancelled']]);
        $updateData = ['status' => $request->status];
        if ($request->filled('notes')) $updateData['notes'] = $request->notes;
        $order->update($updateData);

        if ($request->status === 'confirmed') {
            $mou = MouDocument::firstOrCreate(['order_id' => $order->id]);
            $mou->update(['status' => 'waiting_signature']);
            $order->update(['mou_status' => 'waiting']);
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status order berhasil diupdate.');
    }

    public function updateProduction(Request $request, Order $order)
    {
        $request->validate([
            'production_status' => ['nullable', 'in:antri,mixing,qc,packing,siap_kirim,terkirim'],
            'tracking_number'   => ['nullable', 'string'],
            'courier'           => ['nullable', 'string'],
        ]);
        $order->update($request->only('production_status', 'tracking_number', 'courier'));
        if ($request->production_status) {
            $order->update(['status' => 'in_progress']);
        }
        return redirect()->route('admin.orders.show', $order)->with('success', 'Status produksi berhasil diupdate.');
    }

    public function createInvoice(Request $request, Order $order)
    {
        $request->validate([
            'amount'   => ['required', 'numeric', 'min:1'],
            'due_date' => ['required', 'date', 'after:today'],
            'notes'    => ['nullable', 'string'],
        ]);

        $invoice = Invoice::create([
            'user_id'        => $order->user_id,
            'order_id'       => $order->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'amount'         => $request->amount,
            'status'         => 'pending',
            'due_date'       => $request->due_date,
            'notes'          => $request->notes,
        ]);
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice berhasil dibuat.');
    }
}
