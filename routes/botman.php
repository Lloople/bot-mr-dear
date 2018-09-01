<?php

$botman = resolve('botman');

$botman->hears('/sites', \App\Http\Controllers\Sites\ListController::class);

