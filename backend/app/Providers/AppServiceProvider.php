<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Order;
use App\Policies\InvoicePolicy;
use App\Policies\OrderPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
    }
}
