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
        $order->update(['status' => $request->status]);

        if ($request->status === 'confirmed') {
            // Generate MOU
            $mou = MouDocument::firstOrCreate(['order_id' => $order->id]);
            $mou->update(['status' => 'waiting_signature']);
            $order->update(['mou_status' => 'waiting']);
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status order berhasil diupdate.');
    }

    public function updateProduction(Request $request, Order $order)
    {
        $request->validate([
            'production_status' => ['required', 'in:antri,mixing,qc,packing,siap_kirim,terkirim'],
            'tracking_number'   => ['nullable', 'string'],
            'courier'           => ['nullable', 'string'],
        ]);
        $order->update($request->only('production_status', 'tracking_number', 'courier'));
        return redirect()->route('admin.orders.show', $order)->with('success', 'Status produksi berhasil diupdate.');
    }

    public function createInvoice(Request $request, Order $order)
    {
        $invoice = Invoice::create([
            'user_id'    => $order->user_id,
            'order_id'   => $order->id,
            'amount'     => $order->dp_amount,
            'type'       => 'dp',
            'status'     => 'pending',
            'due_date'   => now()->addDays(7),
        ]);
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice DP berhasil dibuat.');
    }
}
