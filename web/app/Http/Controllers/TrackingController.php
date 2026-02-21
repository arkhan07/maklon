<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('product')
            ->whereIn('status', ['confirmed', 'in_progress'])
            ->latest()
            ->get();

        $allOrders = auth()->user()->orders()->with('product')->latest()->get();

        return view('tracking.index', compact('orders', 'allOrders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('product', 'packagingType', 'mouDocument', 'invoices.payments');
        return view('tracking.show', compact('order'));
    }
}
