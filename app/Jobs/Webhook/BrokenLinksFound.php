<?php

namespace App\Jobs\Webhook;

use App\Models\User;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BrokenLinksFound implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payload;

    /** @var \BotMan\BotMan\BotMan */
    protected $botman;

    /** @var \App\Models\User */
    protected $user;

    public function __construct($payload, User $user)
    {
        $this->payload = $payload;
        $this->user = $user;
        $this->botman = resolve('botman');
    }

    public function handle()
    {
        $this->botman->say(
            trans('ohdear.webhook.broken_links_found', ['url' => $this->payload->site->url]),
            $this->user->telegram_id,
            TelegramDriver::class
        );

        foreach ($this->payload->run->result_payload as $brokenLink) {
            $this->reportBrokenLink($brokenLink);
        }
    }

    private function reportBrokenLink($link)
    {
        $this->botman->say(trans('ohdear.brokenlinks.result', [
            'url' => $link->crawled_url,
            'code' => $link->status_code,
            'origin' => $link->found_on_url
        ]), $this->user->telegram_id, TelegramDriver::class);
    }
}
