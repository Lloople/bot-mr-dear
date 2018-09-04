<?php

namespace App\Http\Controllers\Uptime;

use App\Helpers\Str;
use App\Http\Controllers\Controller;
use App\OhDear\Downtime;
use App\OhDear\Services\OhDear;
use App\OhDear\Uptime;
use BotMan\BotMan\BotMan;

class ShowController extends Controller
{

    /** @var \App\OhDear\Services\OhDear */
    protected $dear;

    const PERCENTAGES_EMOJIS = [
        '🎉' => 100,
        '🙌' => 75,
        '😕' => 50,
        '😞' => 25,
        '😱' => 0,
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

        $uptime = $this->dear->getSiteUptime($site->id);

        $daysWithDowntime = $uptime->filter(function (Uptime $uptime) {
            return $uptime->uptimePercentage !== 100;

        })->each(function (Uptime $uptime) use ($bot) {

            $bot->reply("Your site had a {$uptime->uptimePercentage}% of uptime on {$uptime->datetime} {$this->getPercentageEmoji($uptime->uptimePercentage)}");

        });

        if ($daysWithDowntime->isEmpty()) {
            $firstDay = $uptime->reverse()->first();
            $lastDay = $uptime->first();
            $bot->reply("Your site had a perfect uptime from {$firstDay->datetime} to {$lastDay->datetime}! 🙌");
        }
    }

    private function getPercentageEmoji($percentage)
    {
        foreach (self::PERCENTAGES_EMOJIS as $emoji => $cut) {

            if (abs($percentage - $cut) <= 12.5) {
                return $emoji;
            }
        }

        return '😱';
    }
}
