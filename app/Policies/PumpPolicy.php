<?php

namespace App\Policies;

use App\Models\Boilerplate\User;
use App\Models\Pump;

class PumpPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->ability(['admin'], 'pump_crud');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pump $pump): bool
    {
        return $user->ability(['admin'], 'pump_crud');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pump $pump): bool
    {
        return $user->ability(['admin'], 'pump_crud');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pump $pump): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pump $pump): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pump $pump): bool
    {
        return false;
    }
}
