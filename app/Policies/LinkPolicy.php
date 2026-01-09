<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;

class LinkPolicy
{
    /**
     * Determine if the user can view any links
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the link
     */
    public function view(User $user, Link $link): bool
    {
        return $user->id === $link->profile->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can create links
     */
    public function create(User $user): bool
    {
        return $user->profile !== null;
    }

    /**
     * Determine if the user can update the link
     */
    public function update(User $user, Link $link): bool
    {
        return $user->id === $link->profile->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the link
     */
    public function delete(User $user, Link $link): bool
    {
        return $user->id === $link->profile->user_id || $user->isAdmin();
    }
}
