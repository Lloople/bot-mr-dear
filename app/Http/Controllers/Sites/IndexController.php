<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use App\OhDear\Site;
use BotMan\BotMan\BotMan;

class IndexController extends Controller
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
     *
     * @return void
     */
    public function __invoke(BotMan $bot)
    {
        $bot->types();

        $sites = $this->dear->sites();

        if (! $sites->count()) {
            $bot->reply(trans('ohdear.sites.list_empty'));

            return;
        }

        $sites->each(function (Site $site) use ($bot) {
           $bot->reply($site->getResume());
        });
    }
}
