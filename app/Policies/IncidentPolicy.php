<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncidentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Incident $incident): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Incident $incident): bool
    {
        return true;
    }

    public function delete(User $user, Incident $incident): bool
    {
        return true;
    }

    public function restore(User $user, Incident $incident): bool
    {
        return true;
    }

    public function forceDelete(User $user, Incident $incident): bool
    {
        return true;
    }
}
