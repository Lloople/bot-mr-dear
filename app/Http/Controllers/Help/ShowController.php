<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;

class ShowController extends Controller
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
        $bot->types();

        $bot->reply(trans('ohdear.help.title'));

        $bot->typesAndWaits(1);

        $bot->reply(file_get_contents(resource_path('markdown/help.md')), [
            'parse_mode' => 'Markdown'
        ]);
    }
}
