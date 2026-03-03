<?php

namespace App\Notifications;

use App\Models\Target;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushover\Exceptions\EmergencyNotificationRequiresRetryAndExpire;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Pushover\PushoverMessage;

class UnhealthyTargetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Target $target) {}

    public function via($notifiable): array
    {
        return [PushoverChannel::class];
    }

    public function toArray($notifiable): array
    {
        return $this->target->toArray();
    }

    public function toPushover($notifiable): PushoverMessage
    {
        try {
            return PushoverMessage::create("{$this->target->targetGroup->name}/{$this->target->getInstanceName()} is unhealthy!")
                ->title('Target Unhealthy')
                ->highPriority();
        } catch (EmergencyNotificationRequiresRetryAndExpire) {
            return PushoverMessage::create("{$this->target->targetGroup->name}/{$this->target->getInstanceName()} is unhealthy!")
                ->title('Target Unhealthy');
        }
    }
}
