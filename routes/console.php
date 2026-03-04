<?php

use App\Actions\SyncInstances;
use App\Actions\SyncTargetGroups;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('auth:clear-resets')->hourly()->onOneServer();
Schedule::job(new SyncTargetGroups)->everyMinute()->onOneServer();
Schedule::job(new SyncInstances)->everyThirtyMinutes()->onOneServer();
