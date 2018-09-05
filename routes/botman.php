<?php

$botman = resolve('botman');

$botman->middleware->received(new \App\Http\Middleware\LoadUserMiddleware());

$botman->hears('/start', \App\Http\Controllers\Users\StoreController::class);

$botman->hears('/sites', \App\Http\Controllers\Sites\IndexController::class);
$botman->hears('/newsite (.*[^\s])', \App\Http\Controllers\Sites\CreateController::class);
$botman->hears('/site (.*[^\s])', \App\Http\Controllers\Sites\ShowController::class);
$botman->hears('/deletesite (.*[^\s])', \App\Http\Controllers\Sites\DestroyController::class);
$botman->hears('/downtime (.*[^\s])', \App\Http\Controllers\Downtime\ShowController::class);
$botman->hears('/uptime (.*[^\s])', \App\Http\Controllers\Uptime\ShowController::class);
$botman->hears('/brokenlinks (.*[^\s])', \App\Http\Controllers\BrokenLinks\ShowController::class);
$botman->hears('/mixedcontent (.*[^\s])', \App\Http\Controllers\MixedContent\ShowController::class);
