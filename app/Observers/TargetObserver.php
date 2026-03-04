<?php

namespace App\Observers;

use App\Enums\TargetState;
use App\Models\Target;
use App\Models\User;
use App\Notifications\HealthyTargetNotification;
use App\Notifications\UnhealthyTargetNotification;
use Illuminate\Support\Facades\Notification;

class TargetObserver
{
    public function updating(Target $target): void
    {
        if ($target->isDirty('state')) {
            $users = User::whereNotNull('pushover_key')->get();

            if ($target->state === TargetState::Unhealthy) {
                Notification::send($users, new UnhealthyTargetNotification($target));

                $target->incidents()->create();
            } elseif ($target->state === TargetState::Healthy) {
                Notification::send($users, new HealthyTargetNotification($target));

                $target->incidents()->orderByDesc('created_at')->first()?->delete();
            }
        }
    }
}
