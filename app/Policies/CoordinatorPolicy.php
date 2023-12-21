<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as Coordinator;
use Illuminate\Auth\Access\Response;

class CoordinatorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('coordinator_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Coordinator $coordinator): bool
    {
        return $user->hasPermissionTo('coordinator_read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('coordinator_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Coordinator $coordinator): bool
    {
        return $user->hasPermissionTo('coordinator_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coordinator $coordinator): bool
    {
        return $user->hasPermissionTo('coordinator_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Coordinator $coordinator): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Coordinator $coordinator): bool
    // {
    //     //
    // }
}
