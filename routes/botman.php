<?php

$botman = resolve('botman');

$botman->middleware->received(new \App\Http\Middleware\LoadUserMiddleware());

$botman->hears('/help', \App\Http\Controllers\Help\ShowController::class);

$botman->hears('/start', \App\Http\Controllers\Users\StoreController::class);
$botman->hears('/token {token}', \App\Http\Controllers\Token\StoreController::class);


$botman->hears('/sites', \App\Http\Controllers\Sites\IndexController::class);
$botman->hears('/newsite (.*[^\s])', \App\Http\Controllers\Sites\StoreController::class);
$botman->hears('/site (.*[^\s])', \App\Http\Controllers\Sites\ShowController::class);
$botman->hears('/deletesite (.*[^\s])', \App\Http\Controllers\Sites\DestroyController::class);
$botman->hears('/downtime (.*[^\s])', \App\Http\Controllers\Downtime\ShowController::class);
$botman->hears('/uptime (.*[^\s])', \App\Http\Controllers\Uptime\ShowController::class);
$botman->hears('/brokenlinks (.*[^\s])', \App\Http\Controllers\BrokenLinks\ShowController::class);
$botman->hears('/mixedcontent (.*[^\s])', \App\Http\Controllers\MixedContent\ShowController::class);
