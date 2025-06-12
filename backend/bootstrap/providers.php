<?php

$providers = [
    App\Providers\AppServiceProvider::class,
];

// Conditionally register Telescope only if the package is installed
if (class_exists(\Laravel\Telescope\TelescopeApplicationServiceProvider::class)) {
    $providers[] = App\Providers\TelescopeServiceProvider::class;
}

return $providers;
