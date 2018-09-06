<?php

namespace App\Http\Controllers\MixedContent;

use App\Http\Controllers\Controller;
use App\OhDear\MixedContent;
use App\OhDear\Services\OhDear;
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

        $mixedContent = $this->dear->getMixedContent($site->id);

        if ($mixedContent->isEmpty()) {
            $bot->reply(trans('ohdear.mixedcontent.perfect'));

            return;
        }

        $mixedContent->each(function (MixedContent $mixed) use ($bot) {
            $bot->reply(trans('ohdear.mixedcontent.result', [
                'url' => $mixed->mixedContentUrl,
                'origin' => $mixed->foundOnUrl,
            ]));
        });

        $bot->reply($site->getKeyboard());
    }
}
