<?php

namespace App\Policies;

use App\Models\LoadEntry;
use App\Models\Boilerplate\User;

class LoadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->ability(['admin'], 'load_index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LoadEntry $loadEntry): bool
    {
        return $user->ability(['admin'], 'load_index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->ability(['admin'], 'load_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LoadEntry $loadEntry): bool
    {
        return $user->ability(['admin'], 'load_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LoadEntry $loadEntry): bool
    {
        return $user->ability(['admin'], 'load_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LoadEntry $loadEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LoadEntry $loadEntry): bool
    {
        return false;
    }
}
