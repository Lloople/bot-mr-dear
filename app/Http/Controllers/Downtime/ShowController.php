<?php

namespace App\Http\Controllers\Downtime;

use App\Helpers\Str;
use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class ShowController extends Controller
{

    /** @var \App\OhDear\Services\OhDear */
    protected $dear;

    const INTERVALS_EMOJIS = [
        'months' => '🎉',
        'weeks' => '🙌',
        'days' => '👍',
        'hours' => '😕',
        'minutes' => '😞',
        'seconds' => '😱'
    ];

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
            if (Str::isValidUrl($url)) {
                $bot->reply("/newsite {$url}");
            }

            return;
        }

        $downtime = $this->dear->getSiteDowntime($site->id);

        $elapsed = Str::getElapsedTime($downtime->first()->endedAt);

        $bot->reply("The last time your site was down was {$elapsed['diff']} {$elapsed['interval']} ago {$this->getIntervalEmoji($elapsed['interval'])}");

    }

    private function getIntervalEmoji($interval)
    {
        return self::INTERVALS_EMOJIS[$interval];
    }
}
