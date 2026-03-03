<?php

use App\Actions\SyncInstances;
use App\Actions\SyncTargetGroups;

Schedule::job(new SyncTargetGroups)->everyMinute()->onOneServer();
Schedule::job(new SyncInstances)->everyFourHours()->onOneServer();
