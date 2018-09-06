<?php

namespace App\Http\Controllers\Sites;

use App\Conversations\SiteDestroyConversation;
use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use App\Traits\FindSites;
use BotMan\BotMan\BotMan;

class DestroyController extends Controller
{

    use FindSites;

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

        $site = $this->find($url);

        if (! $site) {
            $bot->reply(trans('ohdear.sites.not_found'));

            return;
        }

        $bot->startConversation(new SiteDestroyConversation($this->dear, $site));
    }
}
