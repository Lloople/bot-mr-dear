<?php

namespace App\Http\Controllers\Sites;

use App\Conversations\SiteDestroyConversation;
use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class DestroyController extends Controller
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
     * @throws \App\Exceptions\SiteNotFoundException
     */
    public function __invoke(BotMan $bot, string $url)
    {
        $site = $this->dear->findSite($url);

        $bot->startConversation(new SiteDestroyConversation($this->dear, $site));
    }
}
