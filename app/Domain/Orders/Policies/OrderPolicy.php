<?php

namespace App\Domain\Orders\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Order $order): Response
    {
        return (int) $order->user_id === (int) $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
