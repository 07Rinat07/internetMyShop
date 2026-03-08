<?php

namespace App\Domain\Accounts\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Profile $profile): Response
    {
        return (int) $profile->user_id === (int) $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Profile $profile): Response
    {
        return (int) $profile->user_id === (int) $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Profile $profile): Response
    {
        return (int) $profile->user_id === (int) $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
