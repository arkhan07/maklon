<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'product_type' => ['nullable', 'string', 'max:100'],
            'quantity'     => ['required', 'integer', 'min:1'],
            'notes'        => ['nullable', 'string', 'max:2000'],
        ], [
            'product_name.required' => 'Nama produk wajib diisi.',
            'quantity.required'     => 'Jumlah wajib diisi.',
            'quantity.min'          => 'Jumlah minimal 1.',
        ]);

        $order = Order::create([
            'user_id'      => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'product_name' => $request->product_name,
            'product_type' => $request->product_type,
            'quantity'     => $request->quantity,
            'notes'        => $request->notes,
            'status'       => 'pending',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', "Order #{$order->order_number} berhasil dibuat! Tim kami akan segera menghubungi Anda.");
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('invoice.payments');
        return view('orders.show', compact('order'));
    }
}
