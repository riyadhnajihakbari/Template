<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\StoreOrder;
use App\Policies\OrderPolicy;
use App\Policies\StoreOrderPolicy;
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
        Gate::policy(StoreOrder::class, StoreOrderPolicy::class);
    }
}