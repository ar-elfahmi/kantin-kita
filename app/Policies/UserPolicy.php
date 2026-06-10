<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function delete(User $admin, User $target): bool
    {
        if (! $admin->isAdmin()) {
            return false;
        }

        return $admin->id !== $target->id;
    }

    public function update(User $admin, User $target): bool
    {
        return $admin->isAdmin();
    }

    public function changeRole(User $admin, User $target, string $newRole): bool
    {
        if (! $admin->isAdmin()) {
            return false;
        }

        if ($admin->id === $target->id && $newRole !== 'admin') {
            return false;
        }

        return true;
    }

    public function restore(User $admin, User $target): bool
    {
        return $admin->isAdmin();
    }
}
