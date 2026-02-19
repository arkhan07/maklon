<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('product_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'invoice.payments');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'      => ['required', 'in:pending,processing,qc,shipping,done,cancelled'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $order->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', "Status order #{$order->order_number} diperbarui ke: {$order->statusLabel()}");
    }

    public function createInvoice(Request $request, Order $order)
    {
        if ($order->invoice) {
            return back()->with('error', 'Invoice untuk order ini sudah ada.');
        }

        $request->validate([
            'amount'   => ['required', 'numeric', 'min:1'],
            'due_date' => ['required', 'date', 'after:today'],
            'notes'    => ['nullable', 'string', 'max:500'],
        ]);

        Invoice::create([
            'order_id'       => $order->id,
            'user_id'        => $order->user_id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'amount'         => $request->amount,
            'status'         => 'pending',
            'due_date'       => $request->due_date,
            'notes'          => $request->notes,
        ]);

        return back()->with('success', 'Invoice berhasil dibuat dan dikirim ke customer.');
    }
}
