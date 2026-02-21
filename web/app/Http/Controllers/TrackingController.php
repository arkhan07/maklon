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
}
