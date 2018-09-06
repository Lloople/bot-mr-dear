<?php

namespace App\Http\Controllers\Sites;

use App\Exceptions\InvalidUrlException;
use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class StoreController extends Controller
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

        if ($this->dear->findSiteByUrl($url)) {
            $bot->reply(trans('ohdear.sites.already_exists'));
            return;
        }

        try {
            $site = $this->dear->createSite($url);

            $bot->reply(trans('ohdear.sites.created'));

        } catch (InvalidUrlException $e) {
            $bot->reply(trans('ohdear.sites.invalid_url'));
        }
    }
}
