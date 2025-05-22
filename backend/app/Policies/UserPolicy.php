<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Adjust as needed, for now, default
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Adjust as needed, for now, default
        // Typically, a user might be able to view their own profile or admins view any.
        // For this task, only update is specified.
        return $user->id === $model->id; 
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User creation is usually handled by RegisterController or similar, not a policy on User itself.
        return false;
    }

    /**
     * Determine whether the user can update the model.
     * User can only update their own profile.
     */
    public function update(User $currentUser, User $targetUser): bool
    {
        return $currentUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $currentUser, User $targetUser): bool
    {
        // For this task, only update is specified.
        // Typically, a user might be able to delete their own profile, or admins delete any.
        return $currentUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
