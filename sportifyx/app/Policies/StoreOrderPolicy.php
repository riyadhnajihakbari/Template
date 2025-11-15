<?php

namespace App\Policies;

use App\Models\StoreOrder;
use App\Models\User;

class StoreOrderPolicy
{
    public function view(User $user, StoreOrder $order): bool
    {
        return $user->id === $order->user_id || $user->isAdmin();
    }
}