<?php

namespace App\Policies;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Instance $instance): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Instance $instance): bool
    {
        return true;
    }

    public function delete(User $user, Instance $instance): bool
    {
        return true;
    }

    public function restore(User $user, Instance $instance): bool
    {
        return true;
    }

    public function forceDelete(User $user, Instance $instance): bool
    {
        return true;
    }
}
