<?php

namespace App\Http\Controllers\Downtime;

use App\Helpers\Str;
use App\Http\Controllers\Controller;
use App\OhDear\Downtime;
use App\OhDear\Services\OhDear;
use BotMan\BotMan\BotMan;

class ShowController extends Controller
{

    /** @var \App\OhDear\Services\OhDear */
    protected $dear;

    const INTERVALS_EMOJIS = [
        'month' => '🎉',
        'week' => '🙌',
        'day' => '👍',
        'hour' => '😕',
        'minute' => '😞',
        'second' => '😱'
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
            if (Str::validate_url($url)) {
                $bot->reply("/newsite {$url}");
            }

            return;
        }

        $downtime = $this->dear->getSiteDowntime($site->id);

        $elapsed = Str::elapsed_time_greatest($downtime->first()->endedAt);

        $bot->reply("The last time your site was down was {$elapsed} ago {$this->getIntervalEmoji($elapsed)}");

        $downtime->each(function (Downtime $downtime) use ($bot) {

            $bot->reply("Your website was down for {$downtime->getDowntime()} on {$downtime->startedAt->format('D, F d, Y')}");
        });

    }

    private function getIntervalEmoji($interval)
    {
        foreach (self::INTERVALS_EMOJIS as $key => $emoji) {
            if (stripos($interval, $key) !== false) {
                return $emoji;
            }
        }

        return self::INTERVALS_EMOJIS['seconds'];
    }
}
