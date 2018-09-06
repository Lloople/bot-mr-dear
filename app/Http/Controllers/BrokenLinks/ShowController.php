<?php

namespace App\Http\Controllers\BrokenLinks;

use App\Helpers\Str;
use App\Http\Controllers\Controller;
use App\OhDear\BrokenLink;
use App\OhDear\Services\OhDear;
use App\OhDear\Uptime;
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
            $bot->reply(trans('ohdear.sites.not_found'));

            return;
        }

        $links = $this->dear->getBrokenLinks($site->id);

        if ($links->isEmpty()) {
            $bot->reply(trans('ohdear.brokenlinks.perfect'));
            
            return;
        }
        
        $links->each(function (BrokenLink $link) use ($bot) {
            $bot->reply(trans('ohdear.brokenlinks.result', [
                'url' => $link->crawledUrl,
                'code' => $link->statusCode,
                'origin' => $link->foundOnUrl
            ]));
        });
    }
}
