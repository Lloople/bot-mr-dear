<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class ShowController extends Controller
{

    /** @var \App\OhDear\Services\OhDear */
    protected $dear;

    public function __construct(OhDear $dear)
    {
        $this->dear = $dear;
    }

    /**
     * Handle the incoming request.
     *
     * @param \BotMan\BotMan\BotMan $bot
     * @param string $url
     *
     * @return void
     */
    public function __invoke(BotMan $bot, string $url)
    {
        $bot->types();

        $site = $this->dear->findSiteByUrl($url);

        if (! $site) {
            $bot->reply('You\'re not currently monitoring this site. Would you like to?');
            $bot->reply("/newsite {$url}");
            return;
        }

        $bot->reply($site->getResume());
        $bot->reply($site->getInformation());
    }
}