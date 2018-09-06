<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;

class StoreController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $bot
     *
     * @return void
     */
    public function __invoke(BotMan $bot, $token)
    {
        auth()->user()->token = encrypt($token);
        auth()->user()->save();

        $bot->reply(trans('ohdear.token.stored'));
    }
}
