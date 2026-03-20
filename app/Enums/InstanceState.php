<?php

namespace App\Enums;

enum InstanceState: string
{
    case Running = 'running';
    case Stopped = 'stopped';
    case Terminated = 'terminated';
}
