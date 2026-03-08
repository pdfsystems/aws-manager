<?php

namespace App\Enums;

enum TargetState: string
{
    case Healthy = 'healthy';
    case Unhealthy = 'unhealthy';
    case Initial = 'initial';
    case Draining = 'draining';
}
