<?php

use App\Providers\HealthServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    HealthServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
];
