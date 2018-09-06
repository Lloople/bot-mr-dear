<?php

namespace App\Http\Controllers\Uptime;

use App\Http\Controllers\Controller;
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
     * @throws \App\Exceptions\SiteNotFoundException
     */
    public function __invoke(BotMan $bot, string $url)
    {
        $bot->types();

        $site = $this->dear->findSite($url);

        $uptime = $this->dear->getSiteUptime($site->id);

        $daysWithDowntime = $uptime->filter(function (Uptime $uptime) {
            return $uptime->uptimePercentage !== 100;

        })->each(function (Uptime $uptime) use ($bot) {

            $bot->reply(trans('ohdear.uptime.result', [
                'percentage' => $uptime->uptimePercentage,
                'date' => $uptime->datetime,
                'emoji' => $uptime->getPercentageEmoji()
                ]));

        });

        if ($daysWithDowntime->isEmpty()) {
            $firstDay = $uptime->reverse()->first();
            $lastDay = $uptime->first();
            $bot->reply(trans('ohdear.uptime.perfect', [
                'begin' => $firstDay->datetime, 'end' => $lastDay->datetime
            ]));
        }

        $bot->reply($site->getKeyboard());
    }


}
