<?php

namespace App\Http\Controllers\MixedContent;

use App\Helpers\Str;
use App\Http\Controllers\Controller;
use App\OhDear\BrokenLink;
use App\OhDear\MixedContent;
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

        $mixedContent = $this->dear->geTMixedContent($site->id);

        if ($mixedContent->isEmpty()) {
            $bot->reply('Your site has no mixed content! 🙌');
            
            return;
        }
        
        $mixedContent->each(function (MixedContent $mixed) use ($bot) {
            $bot->reply("{$mixed->mixedContentUrl}".PHP_EOL."Was found on {$mixed->foundOnUrl}");
        });
    }
}
