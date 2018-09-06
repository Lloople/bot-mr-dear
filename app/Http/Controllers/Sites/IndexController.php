<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\OhDear\Services\OhDear;
use App\OhDear\Site;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

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

        $buttons = $sites->map(function (Site $site) {
            return Button::create($site->getResume())->value("/site {$site->id}");
        })->toArray();

        $message = (new Question(trans('ohdear.sites.list_message')))->addButtons($buttons);

        $bot->reply($message);
    }
}
