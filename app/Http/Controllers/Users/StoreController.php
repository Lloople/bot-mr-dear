<?php

namespace App\Http\Controllers\Users;

use App\Conversations\UserStoreConversation;
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
    public function __invoke(BotMan $bot)
    {
        $bot->startConversation(new UserStoreConversation(auth()->user()));
    }
}
