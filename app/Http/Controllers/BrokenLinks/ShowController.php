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
            $bot->reply('You\'re not currently monitoring this site. Would you like to?');

            if (Str::validate_url($url)) {
                $bot->reply("/newsite {$url}");
            }

            return;
        }

        $links = $this->dear->getBrokenLinks($site->id);

        if ($links->isEmpty()) {
            $bot->reply('Your site has no broken links! 🙌');
            
            return;
        }
        
        $links->each(function (BrokenLink $link) use ($bot) {
            $bot->reply("The url {$link->crawledUrl} returned a {$link->statusCode} error".PHP_EOL."It was found on {$link->foundOnUrl}");
        });
    }
}
