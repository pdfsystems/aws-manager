<?php

namespace App\Policies;

use App\Models\Target;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TargetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view-any', Target::class);
    }

    public function view(User $user, Target $target): bool
    {
        return $user->can('view', $target);
    }

    public function create(User $user): bool
    {
        return $user->can('create', Target::class);
    }

    public function update(User $user, Target $target): bool
    {
        return $user->can('update', $target);
    }

    public function delete(User $user, Target $target): bool
    {
        return $user->can('delete', $target);
    }

    public function restore(User $user, Target $target): bool
    {
        return $user->can('restore', $target);
    }

    public function forceDelete(User $user, Target $target): bool
    {
        return $user->can('force-delete', $target);
    }
}
