<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    /**
     * Determine if the user can view any profiles (admin only)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view the profile
     */
    public function view(User $user, Profile $profile): bool
    {
        // Users can view their own profile, admins can view any
        return $user->id === $profile->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can create a profile
     */
    public function create(User $user): bool
    {
        // Users can create a profile if they don't have one
        return $user->profile === null;
    }

    /**
     * Determine if the user can update the profile
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the profile
     */
    public function delete(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id || $user->isAdmin();
    }
}
