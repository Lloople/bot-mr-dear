<?php

$botman = resolve('botman');

$botman->hears('/sites', \App\Http\Controllers\Sites\IndexController::class);
$botman->hears('/newsite (.*[^\s])', \App\Http\Controllers\Sites\CreateController::class);
$botman->hears('/site (.*[^\s])', \App\Http\Controllers\Sites\ShowController::class);

