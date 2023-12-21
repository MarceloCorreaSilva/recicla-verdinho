<?php

namespace App\Policies;

use App\Models\Swap;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SwapPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('swap_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Swap $swap): bool
    {
        return $user->hasPermissionTo('swap_read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('swap_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Swap $swap): bool
    {
        return $user->hasPermissionTo('swap_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Swap $swap): bool
    {
        return $user->hasPermissionTo('swap_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Swap $swap): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Swap $swap): bool
    // {
    //     //
    // }
}
