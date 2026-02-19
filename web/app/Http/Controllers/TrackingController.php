<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->whereNotIn('status', ['done', 'cancelled'])
            ->latest()
            ->get();

        $allOrders = auth()->user()->orders()->latest()->get();

        return view('tracking.index', compact('orders', 'allOrders'));
    }
}
