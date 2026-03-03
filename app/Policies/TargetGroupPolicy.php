<?php

namespace App\Policies;

use App\Models\TargetGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TargetGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;

    }

    public function view(User $user, TargetGroup $targetGroup): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TargetGroup $targetGroup): bool
    {
        return true;
    }

    public function delete(User $user, TargetGroup $targetGroup): bool
    {
        return true;
    }

    public function restore(User $user, TargetGroup $targetGroup): bool
    {
        return true;
    }

    public function forceDelete(User $user, TargetGroup $targetGroup): bool
    {
        return true;
    }
}
