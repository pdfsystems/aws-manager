<?php

namespace App\Contracts;

interface IncidentSource
{
    public function getIncidentDescription(): string;
}
