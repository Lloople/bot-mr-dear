<?php

namespace App\Jobs\Webhook;

use App\Models\User;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UptimeCheckFailed implements ShouldQueue
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
            trans('ohdear.webhook.uptime_check_failed', ['url' => $this->payload->site->url]),
            $this->user->telegram_id,
            TelegramDriver::class
        );
    }
}
