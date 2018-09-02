<?php

namespace App\Http\Controllers\Sites;

use App\Exceptions\InvalidUrlException;
use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class CreateController extends Controller
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
            $bot->reply('You\'re already monitoring that url 😅');
            return;
        }

        try {
            $site = $this->dear->createSite($url);

            $bot->reply('👍 Oh Dear is now monitoring your site. All checks have been enabled by default.');

        } catch (InvalidUrlException $e) {
            $bot->reply('Sorry, I cannot say that\'s a valid url. Example: https://example.com');
        }
    }
}
