<?php

use App\Actions\SyncTargetGroups;

Schedule::job(new SyncTargetGroups)->everyMinute()->onOneServer();
